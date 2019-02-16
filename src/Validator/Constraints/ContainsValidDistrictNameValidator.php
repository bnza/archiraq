<?php

namespace App\Validator\Constraints;

use App\Entity\Geom\DistrictBoundaryEntity;
use Doctrine\ORM\NoResultException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class ContainsValidDistrictNameValidator extends AbstractEntityManagerRelatedValidator
{
    /**
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof ContainsValidDistrictName) {
            throw new UnexpectedTypeException($constraint, ContainsValidDistrictName::class);
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
        $repo = $this->getEntityManager()->getRepository(DistrictBoundaryEntity::class);
        try {
            $repo->findByName($value);
        } catch (NoResultException $e) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $value)
                ->addViolation();
        }
    }
}
