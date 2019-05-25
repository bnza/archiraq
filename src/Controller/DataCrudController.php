<?php

namespace App\Controller;


class DataCrudController extends AbstractCrudController
{

    private $entitiesMap = [
        'geom-nation' => 'App\\Entity\\Geom\\NationBoundaryEntity',
        'geom-district' => 'App\\Entity\\Geom\\DistrictBoundaryEntity',
        'voc-chronology' => 'App\\Entity\\Voc\\ChronologyEntity',
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
}
