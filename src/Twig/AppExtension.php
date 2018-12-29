<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;


class AppExtension extends AbstractExtension
{
    public function getFilters(){
        return array(
            new TwigFilter('base64_encode', 'base64_encode'),
            new TwigFilter('base64_decode', 'base64_decode')
        );
    }
}