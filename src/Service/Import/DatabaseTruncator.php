<?php

namespace App\Service\Import;

use Doctrine\ORM\EntityManagerInterface;

class DatabaseTruncator
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function truncateAll()
    {
        $connection = $this->em->getConnection();
        $platform = $connection->getDatabasePlatform();

        $tables = [
            'public.site_chronology',
            'public.site_survey',
            'geom.site',
            'public.site',
        ];

        foreach ($tables as $table) {
            $connection->executeStatement($platform->getTruncateTableSQL($table, true));
        }

        // Also truncate contribute if we want a fresh start, 
        // but the plan says "truncate all site-related tables". 
        // Contributes might be linked to other things (though unlikely here).
        // Let's stick to the core site tables.
    }
}
