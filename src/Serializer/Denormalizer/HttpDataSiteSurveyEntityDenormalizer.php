<?php


namespace App\Serializer\Denormalizer;


use App\Entity\SiteSurveyEntity;
use App\Entity\Voc\SurveyEntity;
use Doctrine\Common\Inflector\Inflector;
use Symfony\Component\Serializer\Exception\BadMethodCallException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Exception\ExtraAttributesException;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Exception\RuntimeException;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

class HttpDataSiteSurveyEntityDenormalizer extends GetSetMethodNormalizer
{
    use GetSetMethodNormalizerTrait;

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
     * @throws ExceptionInterface       Occurs for all the other cases of errors
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        if (\array_key_exists('site', $context)) {
            $data['site'] = $context['site'];
        }
        //Negative ids are new entities and will be persisted
        if (\array_key_exists('id', $data) && $data['id'] < 0) {
            unset($data['id']);
        }
        if (\array_key_exists('em', $context)) {
            $data['survey'] = $context['em']->find(SurveyEntity::class, $data['survey']['id']);
        } else {
            $data['survey'] = $this->getGetSetMethodDenormalizer()->denormalize($data['survey'], SurveyEntity::class);
        }

        /**
         * year_low -> yearLow (setYearLow in denormalizer)
         */
        foreach (['year_low','year_high'] as $snakeKey) {
            $camelKey = Inflector::camelize($snakeKey);
            $data[$camelKey] = $data[$snakeKey];
            unset($snakeKey);
        }
        return parent::denormalize($data, SiteSurveyEntity::class);
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
        return SiteSurveyEntity::class === $type;
    }
}
