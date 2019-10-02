<?php


namespace App\Serializer\Denormalizer;

use App\Entity\ContributeEntity;
use App\Entity\Geom\DistrictBoundaryEntity;
use App\Entity\Geom\SiteBoundaryEntity;
use App\Entity\SiteEntity;
use Doctrine\Common\Inflector\Inflector;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NoResultException;
use Symfony\Component\Serializer\Exception\BadMethodCallException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Exception\ExtraAttributesException;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Exception\RuntimeException;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

class HttpDataSiteEntityDenormalizer implements DenormalizerInterface
{
    use EntityManagerDenormalizerTrait;

    /**
     * Denormalizes data back into an object of the given class.
     *
     * @param mixed $data Data to restore
     * @param string $class The expected class to instantiate
     * @param string $format Format the given data was extracted from
     * @param array $context Options available to the denormalizer
     *
     * @return object
     *
     * @throws BadMethodCallException   Occurs when the normalizer is not called in an expected context
     * @throws InvalidArgumentException Occurs when the arguments are not coherent or not supported
     * @throws UnexpectedValueException Occurs when the item cannot be hydrated with the given data
     * @throws ExtraAttributesException Occurs when the item doesn't have attribute to receive given data
     * @throws LogicException           Occurs when the normalizer is not supposed to denormalize
     * @throws RuntimeException         Occurs if the class cannot be instantiated
     * @throws NoResultException
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        $site = new SiteEntity();
        $this->setContribute($data);
        $this->setDistrict($data);
        $this->setCompilationDate($data);
        \array_walk($data, [$this, 'setEntityProp'], $site);
        return $site;
    }

    /**
     * Checks whether the given class is supported for denormalization by this normalizer.
     *
     * @param mixed $data Data to denormalize from
     * @param string $type The class to which the data should be denormalized
     * @param string $format The format being deserialized from
     *
     * @return bool
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return SiteEntity::class === $type;
    }

    /**
     * @param array $data
     * @throws NoResultException
     */
    private function setDistrict(array &$data)
    {
        if (!\array_key_exists('district', $data)) {
            throw new \InvalidArgumentException('data has not "district" key');
        }
        if (!\array_key_exists('district', $data)) {
            throw new \InvalidArgumentException('"district" has not "id" key');
        }
        $data['district'] = $this->getDistrict($data['district']['id']);
    }

    /**
     * @param int $id
     * @return DistrictBoundaryEntity
     * @throws NoResultException
     */
    private function getDistrict(int $id): DistrictBoundaryEntity
    {

        $district = $this->em->find(DistrictBoundaryEntity::class, $id);
        if (is_null($district)) {
            throw new NoResultException();
        }
        /**
         * @var DistrictBoundaryEntity $district;
         */
        return $district;
    }

    /**
     * @param array $data
     * @throws NoResultException
     */
    private function setContribute(array &$data)
    {
        if (!\array_key_exists('contribute', $data)) {
            throw new \InvalidArgumentException('data has not "contribute" key');
        }
        if (!\array_key_exists('contribute', $data)) {
            throw new \InvalidArgumentException('"contribute" has not "id" key');
        }
        $data['contribute'] = $this->getContribute($data['contribute']['id']);
    }

    /**
     * @param int $id
     * @return ContributeEntity
     * @throws NoResultException
     */
    private function getContribute(int $id): ContributeEntity
    {

        $contribute = $this->em->find(ContributeEntity::class, $id);
        if (is_null($contribute)) {
            throw new NoResultException();
        }
        /**
         * @var ContributeEntity $contribute;
         */
        return $contribute;
    }

    private function setEntityProp($value, string $key, SiteEntity $site)
    {
        if (!\in_array($key, ['surveys', 'chronologies']))
        {
            $method = 'set'.Inflector::classify($key);
            $site->$method($value);
        }
    }

    private function setCompilationDate(array &$data)
    {
        if (!\array_key_exists('compilation_date', $data)) {
            throw new \InvalidArgumentException('data has not "compilation_date" key');
        }
        if (!\array_key_exists('date', $data['compilation_date'])) {
            throw new \InvalidArgumentException('"compilation_date" has not "date" key');
        }
        $date = $data['compilation_date']['date'];
        $date = substr($date,0, 10).'T00:00:00+00:00';
        $data['compilation_date'] = \DateTime::createFromFormat(DATE_ATOM, $date);
    }

    private function setGeom(array &$data)
    {
        $geom = (new GetSetMethodNormalizer())->denormalize($data['geom'], SiteBoundaryEntity::class);
        $data['geom'] = $this->em->merge($geom);
    }
}
