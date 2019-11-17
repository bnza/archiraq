<?php

namespace App\Validator\Constraints;

use App\Entity\Voc\ChronologyEntity;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class ChronologyCodesAreUniqueValidator extends AbstractEntityManagerRelatedValidator
{
    /**
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof ChronologyCodesAreUnique) {
            throw new UnexpectedTypeException($constraint, ChronologyCodesAreUnique::class);
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

        //$repo = $this->getEntityManager()->getRepository(ChronologyEntity::class);
        $codes = \explode(';', $value);
        $count = \array_count_values($codes);
        $duplicates = [];
        foreach ($count as $code => $num) {
            if ($count[$code] > 1) {
                $duplicates[] = $code;
            }
        }
        if ($duplicates) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', \implode(';',$duplicates))
                ->addViolation();
        }
    }
}
