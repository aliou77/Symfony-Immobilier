<?php

namespace App\Tests\Unit;

use App\Entity\Property;
use App\Entity\PropertyTag;
use PHPUnit\Framework\TestCase;

class PropertyTagUnitTest extends TestCase
{
    public function testIsTrue(): void
    {
        $t = new PropertyTag();
        $t->setName('name');

        $this->assertTrue($t->getName() == 'name');
    }

    public function testAddRemove(): void{
        $p = new Property();
        $t = new PropertyTag();

        $this->assertEmpty($t->getProperties());
        $t->addProperty($p);
        $this->assertContains($p, $t->getProperties());

        $t->removeProperty($p);
        $this->assertEmpty($t->getProperties());
    }

    public function testIsNull(): void{
        $t = new PropertyTag();
        $this->assertNull($t->getId());
    }

    public function testToString(): void{
        $t = new PropertyTag();
        $t->setName('name');
        $this->assertTrue($t->__toString() == 'name');
    }
}
