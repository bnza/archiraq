<?php


namespace App\Service\ParametersConverter;


use App\Entity\Voc\ChronologyEntity;
use App\Repository\Voc\ChronologyRepository;
use Doctrine\ORM\EntityManagerInterface;

class TmpDraftArrayToPublicSiteChronologyParametersArrayConverter
{

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var ChronologyRepository
     */
    private $chronologyRepository;

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
        $params = [
            'site_id' => $draft['id']
        ];
        $params['site_chronologies'] = $this->getChronologiesIds($draft);
        return $params;
    }

    private function getChronologyRepository(): ChronologyRepository
    {
        if (!$this->chronologyRepository) {
            $this->chronologyRepository = $this->em->getRepository(ChronologyEntity::class);
        }
        return $this->chronologyRepository;
    }

    private function getChronologiesIds($draft): array
    {
        $ids = [];
        $chronologiesString = $draft['site_chronology'];
        if (is_string($chronologiesString)) {
            $chronologyRepository = $this->getChronologyRepository();
            foreach (\explode(';', $chronologiesString) as $chronologyCode) {
                $chronologyCode = (strtoupper(trim($chronologyCode)));
                $chronology = $chronologyRepository->findOneBy(['code' => $chronologyCode]);
                $ids[] = $chronology->getId();
            }
        }
        return $ids;

    }

}
