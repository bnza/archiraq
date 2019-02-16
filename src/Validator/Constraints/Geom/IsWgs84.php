<?php

namespace App\Validator\Constraints\Geom;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class IsWgs84 extends Constraint
{
    public $message = 'Provided geometry EPSG SRID is "{{ srid }}": 4326 is required';
}
