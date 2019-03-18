<?php

namespace App\Controller;


class DataCrudController extends AbstractCrudController
{

    private $entitiesMap = [
        'geom-nation' => 'App\\Entity\\Geom\\NationBoundaryEntity',
        'vw-site' => 'App\\Entity\\View\\SiteEntity'
    ];

    /**
     * Map the request entity name to the entity class name
     * @param $entityName
     * @return string
     */
    public function getEntityClass($entityName): string
    {
        if (array_key_exists($entityName, $this->entitiesMap)) {
            return $this->entitiesMap[$entityName];
        }
        throw new \InvalidArgumentException("\"$entityName\" is not mapped in this controller");
    }
}
