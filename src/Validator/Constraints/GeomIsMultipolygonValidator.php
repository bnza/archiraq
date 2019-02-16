<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

/**
 * @Annotation
 */
class GeomIsMultipolygonValidator extends AbstractEntityManagerRelatedValidator
{
    /**
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof IsMultipolygon) {
            throw new UnexpectedTypeException($constraint, IsMultipolygon::class);
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
        $sql = 'SELECT GeometryType(ST_GeomFromGeoJSON(:geom))';
        $stmt = $conn->prepare($sql);
        $stmt->bindValue('geom', $value);
        $type = $stmt->fetchColumn();

        if ('multipolygon' !== strtolower($type)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $type)
                ->addViolation();
        }
    }
}
