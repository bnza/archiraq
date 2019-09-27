<?php


namespace App\Service;


use App\Entity\SiteEntity;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Inflector\Inflector;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class HttpDataSiteChildrenUpdater extends AbstractHttpDataUpdater
{
    /**
     * @var string
     */
    protected $entityClass;

    /**
     * @var string
     */
    protected $vocabularyClass;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var DenormalizerInterface
     */
    protected $denormalizer;

    public function __construct(EntityManagerInterface $em, string $type)
    {
        $this->type = $type;
        parent::__construct($em);
    }

    public function getChildrenType(bool $classify = false): string
    {
        $key = $this->type;
        if ($classify) {
            $key = Inflector::classify($key);
        }
        return $key;
    }

    public function getEntityClass(): string
    {
        return "\App\Entity\Site{$this->getChildrenType(true)}Entity";
    }

    protected function getChildrenMethod():string
    {
        return 'get'.Inflector::classify(Inflector::pluralize($this->type));
    }

    protected function getDenormalizer(): DenormalizerInterface
    {
        if (!$this->denormalizer) {
            $class = "\App\Serializer\Denormalizer\HttpDataSite{$this->getChildrenType(true)}EntityDenormalizer";
            $this->denormalizer = new $class();
        }
        return $this->denormalizer;
    }

    protected function findSite(int $id): SiteEntity
    {
        return $this->em->find(SiteEntity::class, $id);
    }

    public function removeDeletedChildren(SiteEntity $site, $data)
    {
        $ids = $this->getDataChildrenIds($data);
        $criteria = Criteria::create()
            ->where(
                Criteria::expr()->notIn('id',$ids)
            );
        $method = $this->getChildrenMethod();
        $deleted = $this->findSite($site->getId())->$method()->matching($criteria);
        foreach ($deleted as $child) {
            $this->em->remove($child);
        }
    }

    protected function getDataChildrenIds(array $data): array
    {
        return array_filter(
            array_map(
                function ($item) {
                    return \array_key_exists('id', $item) ? $item["id"] : null;
                },
                $data
            ),
            function ($value) {
                return is_int($value);
            }
        );
    }

    protected function updateChildren(SiteEntity $site, array $data)
    {
        foreach ($data as $child) {
            $childEntity = $this->getDenormalizer()->denormalize($child, $this->getEntityClass(), null, ['site' => $site, 'em'=>$this->em]);
            if (\array_key_exists('id', $child) && \is_int($child['id']))
            {
                $this->em->merge($childEntity);
            } else {
                $this->em->persist($childEntity);
            }
        }
    }

    public function update(SiteEntity $site, array $data)
    {
        $this->removeDeletedChildren($site, $data);
        $this->updateChildren($site, $data);
    }
}
