<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CreateSurveyNotSampledLayerCommand extends Command
{
    protected static $defaultName = 'app:geoserver:create-survey-not-sampled-layer';

    private const WORKSPACE = 'archiraq';
    private const DATASTORE = 'main_geo_db';
    private const LAYERS = [
        'vw_site_survey_not_sampled_point',
        'vw_site_survey_not_sampled_poly',
    ];

    protected function configure()
    {
        $this
            ->setDescription('Creates GeoServer layers for survey not sampled views.')
            ->addOption('credentials', 'c', InputOption::VALUE_REQUIRED, 'GeoServer credentials (user:pass)', 'admin:admin')
            ->addOption('url', 'u', InputOption::VALUE_REQUIRED, 'GeoServer base URL', 'http://localhost:8000')
            ->addOption('rollback', 'r', InputOption::VALUE_NONE, 'Rollback (delete) the layers');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $credentials = $input->getOption('credentials');
        $baseUrl = rtrim($input->getOption('url'), '/') . '/geoserver/rest';
        $rollback = $input->getOption('rollback');

        if ($rollback) {
            $io->title('Rolling back GeoServer Layers');
            foreach (self::LAYERS as $layer) {
                $this->deleteLayer($io, $baseUrl, $credentials, $layer);
            }
        } else {
            $io->title('Creating GeoServer Layers');
            foreach (self::LAYERS as $layer) {
                $this->createLayer($io, $baseUrl, $credentials, $layer);
            }
        }

        return 0;
    }

    private function createLayer(SymfonyStyle $io, string $baseUrl, string $credentials, string $layerName)
    {
        $io->text("Creating layer: $layerName");

        $title = str_replace('_', ' ', $layerName);
        $title = ucwords($title);

        $nativeCRS = 'GEOGCS["WGS 84", 
  DATUM["World Geodetic System 1984", 
    SPHEROID["WGS 84", 6378137.0, 298.257223563, AUTHORITY["EPSG","7030"]], 
    AUTHORITY["EPSG","6326"]], 
  PRIMEM["Greenwich", 0.0, AUTHORITY["EPSG","8901"]], 
  UNIT["degree", 0.017453292519943295], 
  AXIS["Geodetic longitude", EAST], 
  AXIS["Geodetic latitude", NORTH], 
  AUTHORITY["EPSG","4326"]]';

        $url = "$baseUrl/workspaces/" . self::WORKSPACE . "/datastores/" . self::DATASTORE . "/featuretypes?recalculate=nativebbox,latlonbbox";
        $xml = "<featureType>
            <name>$layerName</name>
            <nativeName>$layerName</nativeName>
            <title>$title</title>
            <nativeCRS><![CDATA[$nativeCRS]]></nativeCRS>
            <srs>EPSG:4326</srs>
            <projectionPolicy>FORCE_DECLARED</projectionPolicy>
            <enabled>true</enabled>
            <metadata>
                <entry key=\"JDBC_VIRTUAL_TABLE_PRIMARY_KEY\">id</entry>
            </metadata>
        </featureType>";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $credentials);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/xml']);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 201) {
            $io->success("Layer $layerName created successfully.");
        } elseif ($httpCode === 401) {
            $io->error("Unauthorized: check credentials.");
        } elseif ($httpCode === 500 && strpos($response, 'already exists') !== false) {
            $io->warning("Layer $layerName already exists.");
        } else {
            $io->error("Failed to create layer $layerName. HTTP Code: $httpCode. Response: $response");
        }
    }

    private function deleteLayer(SymfonyStyle $io, string $baseUrl, string $credentials, string $layerName)
    {
        $io->text("Deleting layer: $layerName");

        // 1. Delete Layer
        $layerUrl = "$baseUrl/layers/" . self::WORKSPACE . ":$layerName";
        $this->sendDelete($io, $layerUrl, $credentials, "Layer $layerName");

        // 2. Delete FeatureType
        $featureTypeUrl = "$baseUrl/workspaces/" . self::WORKSPACE . "/datastores/" . self::DATASTORE . "/featuretypes/$layerName";
        $this->sendDelete($io, $featureTypeUrl, $credentials, "FeatureType $layerName");
    }

    private function sendDelete(SymfonyStyle $io, string $url, string $credentials, string $label)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $credentials);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200) {
            $io->success("$label deleted successfully.");
        } elseif ($httpCode === 404) {
            $io->note("$label does not exist.");
        } else {
            $io->error("Failed to delete $label. HTTP Code: $httpCode. Response: $response");
        }
    }
}
