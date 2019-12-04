<?php


namespace App\Service\ParametersConverter;


use App\Entity\Geom\DistrictBoundaryEntity;
use App\Repository\Geom\DistrictBoundaryRepository;
use Doctrine\ORM\EntityManagerInterface;

class TmpDraftArrayToPublicSiteParametersArrayConverter
{
    /**
     * @var array
     */
    private $siteFields = [
        "contribute_id",
        "entry_id",
        "nearest_city",
        "ancient_name",
        "ancient_name_uncertain",
        "modern_name",
        "cadastre",
        "compiler",
        "compilation_date",
        "remarks",
        "credits",
        "sbah_no",
        "features_epigraphic",
        "features_ancient_structures",
        "features_paleochannels",
        "features_remarks",
        "threats_natural_dunes",
        "threats_looting",
        "threats_cultivation_trenches",
        "threats_modern_structures",
        "threats_modern_canals",
        "district_id",
        "threats_bulldozer",
        "remote_sensing",
        "survey_verified_on_field"
    ];

    private $booleanFields = [
        "features_epigraphic",
        "features_ancient_structures",
        "features_paleochannels",
        "threats_natural_dunes",
        "threats_looting",
        "threats_cultivation_trenches",
        "threats_modern_structures",
        "threats_modern_canals",
        "threats_bulldozer",
        "remote_sensing",
        "survey_verified_on_field"
    ];

    /**
     * @var array
     */
    private $pluckedSiteFields;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var DistrictBoundaryRepository
     */
    private $districtRepository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param array $draft
     * @return array
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function convert(array $draft): array
    {
        $params = $this->setDistrictId($draft);
        $params = $this->setAncientName($params);
        $params = array_intersect_key($params, $this->getPluckedSiteFields());
        $params = $this->castBooleanFields($params);
        return $params;
    }

    private function getDistrictRepository(): DistrictBoundaryRepository
    {
        if (!$this->districtRepository) {
            $this->districtRepository = $this->em->getRepository(DistrictBoundaryEntity::class);
        }
        return $this->districtRepository;
    }

    /**
     * @param array $draft
     * @return array
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    private function setDistrictId(array $draft): array
    {
        $draft['district_id'] = $this->getDistrictRepository()->findByName($draft['district'])->getId();
        return $draft;
    }

    private function setAncientName(array $draft): array
    {
        if ($draft['ancient_name']) {
            $name = $draft['ancient_name'];
            if ('?' === substr($name, 0, 1)) {
                $draft['ancient_name'] = substr($name, 1);
                $draft['ancient_name_uncertain'] = 'TRUE';
            } else {
                $draft['ancient_name_uncertain'] = 'FALSE';
            }
        }  else {
            $draft['ancient_name_uncertain'] = null;
        }
        return $draft;
    }

    /**
     * @see https://stackoverflow.com/questions/13975984/in-php-is-there-a-way-to-get-a-subset-of-an-array-whose-keys-match-the-values-i
     */
    private function getPluckedSiteFields()
    {
        if (!$this->pluckedSiteFields) {
            $this->pluckedSiteFields = \array_flip($this->siteFields);
        }
        return $this->pluckedSiteFields;
    }

    private function castBooleanFields(array $draft) {
        foreach ($this->booleanFields as $field) {
            $draft[$field] = $this->castBoolean($draft[$field]);
        }
        return $draft;
    }

    private function castBoolean($subject)
    {
        if (is_bool($subject)) {
            return $subject ? 'TRUE' : 'FALSE';
        }

        if (is_null($subject)) {
            return $subject;
        }

        if (is_int($subject)) {
            return (bool) $subject ? 'TRUE' : 'FALSE';
        }
        if (is_string($subject)) {
            $subject = strtolower(\trim($subject));
            if (\in_array($subject, ['y', '1', 't', 'true'])) {
                return 'TRUE';
            }

            return 'FALSE';
        }
    }

}
