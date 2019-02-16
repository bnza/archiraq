<?php

namespace App\Validator\Constraints;

use App\Entity\VocChronologyEntity;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class ContainsValidChronologyCodesValidator extends AbstractEntityManagerRelatedValidator
{
    /**
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof ContainsValidChronologyCodes) {
            throw new UnexpectedTypeException($constraint, ContainsValidChronologyCodes::class);
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
        $repo = $this->getEntityManager()->getRepository(VocChronologyEntity::class);
        foreach (\explode(';', $value) as $code) {
            if (!$repo->codeExists($code)) {
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ string }}', $code)
                    ->addViolation();
            }
        }
    }
}
