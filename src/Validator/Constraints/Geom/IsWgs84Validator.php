<?php

namespace App\Validator\Constraints\Geom;

use App\Validator\Constraints\AbstractEntityManagerRelatedValidator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

/**
 * @Annotation
 */
class IsWgs84Validator extends AbstractEntityManagerRelatedValidator
{
    /**
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof IsWgs84) {
            throw new UnexpectedTypeException($constraint, IsWgs84::class);
        }

        // custom constraints should ignore null and empty values to allow
        // other constraints (NotBlank, NotNull, etc.) take care of that
        if (null === $value || '' === $value) {
            return;
        }

        if (!is_string($value)) {
            // throw this exception if your validator cannot handle the passed type so that it can be marked as invalid
            throw new UnexpectedValueException($value, 'string');
            // separate multiple types using pipes
            // throw new UnexpectedValueException($value, 'string|int');
        }
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT ST_SRID(ST_GeomFromGeoJSON(:geom))';
        $stmt = $conn->prepare($sql);
        $stmt->execute([$value]);
        $srid = $stmt->fetchColumn();

        if (4326 !== $srid) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ srid }}', $srid)
                ->addViolation();
        }
    }
}
