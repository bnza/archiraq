<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ContainsValidChronologyCodes extends Constraint
{
    public $message = 'The chronology code "{{ string }}" does not exist.';
}
