<?php


namespace App\Runner\Task\Database\Raw;

use App\Runner\Task\TaskEntityManagerTrait;
use Bnza\JobManagerBundle\Event\JobEndedEvent;
use Bnza\JobManagerBundle\Runner\Task\AbstractTask;

class DisableMaterializedSiteUpdateTriggerTask extends AbstractTask
{
    use TaskEntityManagerTrait;

    public function getName(): string
    {
        return 'app:task:db:raw:disable-mat_site-trigger';
    }

    public function getDefaultDescription(): string
    {
        return 'Disable "geom"."mat_site" update triggers';
    }

    protected function executeStep(array $arguments): void
    {
        $this->disableTriggers();
    }

    public function getSteps(): iterable
    {
        return [
            []
        ];
    }

    public function configure(): void
    {
        $this->getJob()->getDispatcher()->addListener(JobEndedEvent::NAME, [$this, 'enableTriggers']);
    }

    private function disableTriggers()
    {
        $sql = <<<EOT
ALTER TABLE "geom"."site" DISABLE TRIGGER tr_aud___update_geom_mat_site___geom;
ALTER TABLE "public"."site" DISABLE TRIGGER tr_ai___insert_into_geom_mat_site;
ALTER TABLE "public"."site" DISABLE TRIGGER tr_au___update_geom_mat_site;
ALTER TABLE "public"."site_chronology" DISABLE TRIGGER tr_aud___update_geom_mat_site___chronology;
ALTER TABLE "public"."site_survey" DISABLE TRIGGER tr_aud___update_geom_mat_site___survey;
EOT;
        $this->getEntityManager()->getConnection()->exec($sql);
    }

    public function enableTriggers()
    {
        $sql = <<<EOT
ALTER TABLE "geom"."site" ENABLE TRIGGER tr_aud___update_geom_mat_site___geom;
ALTER TABLE "public"."site" ENABLE TRIGGER tr_ai___insert_into_geom_mat_site;
ALTER TABLE "public"."site" ENABLE TRIGGER tr_au___update_geom_mat_site;
ALTER TABLE "public"."site_chronology" ENABLE TRIGGER tr_aud___update_geom_mat_site___chronology;
ALTER TABLE "public"."site_survey" ENABLE TRIGGER tr_aud___update_geom_mat_site___survey;
EOT;
        $this->getEntityManager()->getConnection()->exec($sql);
    }
}
