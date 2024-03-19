<?php

namespace App\Tests\Unit;

use App\Entity\Option;
use App\Entity\Property;
use PHPUnit\Framework\TestCase;

class OptionUnitTest extends TestCase
{
    public function testIsTrue(): void
    {
        $p = new Property();
        $o = new Option();
        $o
         ->setName('option')
        ;


        $this->assertTrue($o->getName() == "option");
    }

    public function testIsEmpty(): void{
        $o = new Option();
        $this->assertEmpty($o->getId());
        $this->assertEmpty($o->getProperties());
    }

    public function testAddRemoveProperty(): void{
        $p = new Property();
        $o = new Option();

        $o->addProperty($p);
        $this->assertContains($p, $o->getProperties());

        $o->removeProperty($p);
        $this->assertEmpty($o->getProperties());
    }

    public function testToString(): void{
        $o = new Option();
        $o->setName('name');
        $this->assertTrue($o->__toString() == 'name');
    }
}
