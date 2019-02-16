<?php

namespace App\Validator\Constraints\Geom;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class IsMultipolygon extends Constraint
{
    public $message = 'Provided geometry is a "{{ string }}" not a MULTIPOLYGON';
}
