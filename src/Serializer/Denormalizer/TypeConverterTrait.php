<?php
/**
 * Created by PhpStorm.
 * User: petrux
 * Date: 14/02/19
 * Time: 10.13.
 */

namespace App\Serializer\Denormalizer;

trait TypeConverterTrait
{
    public function cast($subject, string $type, array $options = [])
    {
        $handleNulls = \array_key_exists('handle_nulls', $options) ?
            $options['handle_nulls']
            : false;

        if (!$handleNulls && \is_null($subject)) {
            return null;
        }

        $subjectType = \gettype($subject);
        if ('object' === $subjectType) {
            $subjectType = \get_class($subject);
        }

        $method = sprintf('cast%sTo%s', ucfirst($subjectType), ucfirst($type));
        if (\method_exists($this, $method)) {
            return \call_user_func([$this, $method], $subject, $options);
        } else {
            throw new \InvalidArgumentException("No cast method found from \"$subjectType\" to \"$type\"");
        }
    }

    protected function castIntegerToBoolean(int $subject, $options)
    {
        return (bool) $subject;
    }

    protected function castStringToBoolean(string $subject, $options)
    {
        $subject = strtolower(\trim($subject));
        if (\in_array($subject, ['y', '1', 't', 'true'])) {
            return true;
        }

        return false;
    }

    protected function castStringToDate(string $subject, $options)
    {
        $format = \array_key_exists('format', $options) ? $options['format'] : 'Y-m-d';

        return \DateTime::createFromFormat($format, \trim($subject));
    }
}
