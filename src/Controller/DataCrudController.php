<?php

namespace App\Controller;



use App\Entity\SiteEntity;
use App\Service\HttpDataSiteUpdater;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;

class DataCrudController extends AbstractCrudController
{
    private $entitiesMap = [
        'geom-nation' => 'App\\Entity\\Geom\\NationBoundaryEntity',
        'geom-district' => 'App\\Entity\\Geom\\DistrictBoundaryEntity',
        'site' => 'App\\Entity\\SiteEntity',
        'voc-chronology' => 'App\\Entity\\Voc\\ChronologyEntity',
        'voc-survey' => 'App\\Entity\\Voc\\SurveyEntity',
        'vw-site' => 'App\\Entity\\View\\SiteEntity',
    ];

    /**
     * Map the request entity name to the entity class name.
     *
     * @param $entityName
     *
     * @return string
     */
    public function getEntityClass($entityName): string
    {
        if (array_key_exists($entityName, $this->entitiesMap)) {
            return $this->entitiesMap[$entityName];
        }
        throw new \InvalidArgumentException("\"$entityName\" is not mapped in this controller");
    }

    public function updateSite(Request $request, $id)
    {
        $updater = new HttpDataSiteUpdater($this->getEntityManager());
        $updater->update($request->getContent());
        $this->setStatusCode(204);
        return $this->respond(null);
    }

    public function getDistrictNames()
    {
        $data = $this->getRepository('geom-district')->getEntries();

        return $this->respond($data);
    }

    public function getChronologyNames()
    {
        $data = $this->getRepository('voc-chronology')->getEntries();

        return $this->respond($data);
    }

    public function getSurveyCodesStartingWith(Request $request, string $pattern)
    {
        $data = $this->getRepository('voc-survey')->filterByCodeStartWith($pattern);
        if ($request->query->has('code-only') && $request->query->get('code-only') === '1') {
            $data = array_map(function ($entity) {
                return $entity['code'];
            },
                $data);
        }
        return $this->respond($data);
    }
}
