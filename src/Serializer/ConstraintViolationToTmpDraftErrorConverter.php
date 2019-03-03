<?php

namespace App\Serializer;

use App\Entity\Tmp\DraftErrorEntity;
use App\Serializer\Denormalizer\TmpDraftErrorEntityDenormalizer;
use App\Serializer\Normalizer\ConstraintViolationNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\ConstraintViolation;

class ConstraintViolationToTmpDraftErrorConverter extends AbstractConverter
{
    protected function initSerializer(): Serializer
    {
        return new Serializer([new ConstraintViolationNormalizer(), new TmpDraftErrorEntityDenormalizer()]);
    }

    public function getSourceClass(): string
    {
        return ConstraintViolation::class;
    }

    public function getTargetClass(): string
    {
        return DraftErrorEntity::class;
    }
}
