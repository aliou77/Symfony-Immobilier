<?php

namespace App\Tests\Unit;

use App\Entity\Option;
use App\Entity\PropertySearch;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class PropertySearchUnitTest extends TestCase
{
    public function testIsTrue(): void
    {
        $o = new Option();
        $p = new PropertySearch();
        $array = new ArrayCollection([$o]);
        $p
            ->setMaxPrice(1000)
            ->setMinSurface(10)
            ->setOptions($array)
        ;
        $this->assertTrue($p->getMaxPrice() == 1000);
        $this->assertTrue($p->getMinSurface() == 10);
        $this->assertTrue($p->getOptions() == $array);
    }
}
