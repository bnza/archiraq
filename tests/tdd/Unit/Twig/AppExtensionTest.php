<?php

namespace App\Tests\Unit\Twig;


use App\Twig\AppExtension;

class AppExtensionTest extends \PHPUnit\Framework\TestCase
{
    public function testBase64Filter() {
        $ext = new AppExtension();
        $this->assertContainsOnlyInstancesOf(\Twig_Filter::class, $ext->getFilters());
    }
}
