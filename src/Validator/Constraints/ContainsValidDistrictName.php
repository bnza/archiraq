<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ContainsValidDistrictName extends Constraint
{
    public $message = '"{{ string }}" district does not exist.';
}
