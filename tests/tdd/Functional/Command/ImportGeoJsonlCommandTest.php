<?php

namespace App\Tests\Functional\Command;

use App\Tests\Functional\AbstractPgTestIsolation;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class ImportGeoJsonlCommandTest extends AbstractPgTestIsolation
{
    public static function setUpBeforeClass(): void
    {
        self::setUpDatabaseSchema();
    }

    public function setUp()
    {
        $this->savepoint();
    }

    public function tearDown()
    {
        $this->rollbackSavepoint();
    }

    public static function tearDownAfterClass(): void
    {
        self::rollbackDatabaseSchema();
    }

    public function testExecute()
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $command = $application->find('app:import:geojsonl');
        $commandTester = new CommandTester($command);

        $fixtureFile = 'tests/fixtures/geojsonl/survey.jsonl';

        $commandTester->execute([
            'command'  => $command->getName(),
            'file' => $fixtureFile,
            '--type' => 'SURVEY',
            '--email' => 'test_cmd@example.com',
            '--contributor' => 'Tester',
            '--institution' => 'Test Lab',
            '--description' => 'Test import',
            '--batch-size' => 1
        ]);

        $output = $commandTester->getDisplay();
        $this->assertContains('Starting Import', $output);
        $this->assertContains('Imported 1 features successfully', $output);
        $this->assertContains('Refreshing materialized view', $output);
        $this->assertContains('Refresh complete', $output);
        
        $this->assertEquals(0, $commandTester->getStatusCode());
    }

    public function testExecuteDryRun()
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $command = $application->find('app:import:geojsonl');
        $commandTester = new CommandTester($command);

        $fixtureFile = 'tests/fixtures/geojsonl/survey.jsonl';

        $commandTester->execute([
            'command'  => $command->getName(),
            'file' => $fixtureFile,
            '--type' => 'SURVEY',
            '--email' => 'dryrun@example.com',
            '--contributor' => 'DryRunner',
            '--institution' => 'DryLab',
            '--description' => 'DryRun test',
            '--dry-run' => true
        ]);

        $output = $commandTester->getDisplay();
        $this->assertContains('Dry-run mode: no changes will be saved', $output);
        $this->assertContains('Dry-run finished. 1 features validated', $output);
        
        $this->assertEquals(0, $commandTester->getStatusCode());
    }

    public function testExecuteWithErrors()
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $command = $application->find('app:import:geojsonl');
        $commandTester = new CommandTester($command);

        $fixtureFile = 'tests/fixtures/geojsonl/invalid.jsonl';

        $commandTester->execute([
            'command'  => $command->getName(),
            'file' => $fixtureFile,
            '--type' => 'SURVEY',
            '--email' => 'error@example.com',
            '--contributor' => 'ErrorTester',
            '--institution' => 'ErrorLab',
            '--description' => 'Error test'
        ]);

        $output = $commandTester->getDisplay();
        $this->assertContains('Import failed with 3 errors', $output);
        $this->assertContains('INVALID001', $output);
        $this->assertContains('Unrecognized chronology code: NON_EXISTENT_CODE', $output);
        $this->assertContains('INVALID002', $output);
        $this->assertContains('district: This value should not be blank', $output);
        $this->assertContains('Duplicate entry id INVALID001 found within the same import file', $output);
        $this->assertContains('Transaction rolled back', $output);
        
        $this->assertEquals(1, $commandTester->getStatusCode());
    }

    public function testDistrictFallback()
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $command = $application->find('app:import:geojsonl');
        $commandTester = new CommandTester($command);

        $fixtureFile = 'tests/fixtures/geojsonl/district_fallback.jsonl';

        $commandTester->execute([
            'command'  => $command->getName(),
            'file' => $fixtureFile,
            '--type' => 'SURVEY',
            '--email' => 'district@example.com',
            '--contributor' => 'DistrictTester',
            '--institution' => 'DistrictLab',
            '--description' => 'District fallback test'
        ]);

        $output = $commandTester->getDisplay();
        // BOTH_NULL has no district, so validation fails and the whole import is rolled back
        $this->assertContains('Import failed with 1 errors', $output);
        $this->assertContains('BOTH_NULL', $output);
        $this->assertContains('district: This value should not be blank', $output);
        $this->assertEquals(1, $commandTester->getStatusCode());
    }
}
