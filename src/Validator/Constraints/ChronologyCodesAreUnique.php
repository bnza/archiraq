<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ChronologyCodesAreUnique extends Constraint
{
    public $message = 'The chronology code "{{ string }}" is duplicate.';
}
