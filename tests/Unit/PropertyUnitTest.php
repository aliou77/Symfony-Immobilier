<?php

namespace App\Tests\Unit;

use App\Entity\Option;
use App\Entity\Property;
use App\Entity\PropertyTag;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class PropertyUnitTest extends TestCase
{
    public function testIsTrue(): void
    {
        $option = new Option();
        $tag = new PropertyTag();
        $p = new Property();
        $date = new DateTimeImmutable();
        $p 
            ->setTitle('title')
            ->setDescription("description")
            ->setSurface(5)
            ->setBedrooms(5)
            ->setRooms(5)
            ->setFloor(5)
            ->setPrice(5000)
            ->setHeat(1)
            ->setCity("city")
            ->setAddress('address')
            ->setPostalCode("00000")
            ->setSold(false)
            ->setTag($tag)
            ->setCreatedAt($date)
            ->setImageName("image.jpg")
            ->setImageSize(2552)
            ->setLatitude(1.0)
            ->setLongitude(1.0)
            ->addOption($option)
        ;


        $this->assertTrue($p->getTitle() == "title");
        $this->assertTrue($p->getDescription() == "description");
        $this->assertTrue($p->getSurface() == 5);
        $this->assertTrue($p->getBedrooms() == 5);
        $this->assertTrue($p->getRooms() == 5);
        $this->assertTrue($p->getFloor() == 5);
        $this->assertTrue($p->getHeat() == 1);
        $this->assertTrue($p->getPrice() == 5000);
        $this->assertTrue($p->getAddress() == "address");
        $this->assertTrue($p->getCity() == "city");
        $this->assertTrue($p->getPostalCode() == "00000");
        $this->assertTrue($p->isSold() == false);
        $this->assertTrue($p->getCreatedAt() == $date);
        $this->assertTrue($p->getTag() == $tag);
        $this->assertTrue($p->getImageName() == "image.jpg");
        $this->assertTrue($p->getImageSize() == 2552);
        $this->assertTrue($p->getLatitude() == 1.0);
        $this->assertTrue($p->getLongitude() == 1.0);
        $this->assertTrue($p->getTypeHeat(1) == "Gaz");
        $this->assertTrue($p->getSlug("slug") == "slug");
        $this->assertTrue($p->getTruncatedString("slug", 10) == "slug");
    }

    public function testIsEmpty(){
        $p = new Property();
        $this->assertEmpty($p->getId());
        $this->assertEmpty($p->getFormatedPrice());
        $this->assertEmpty($p->getImageFile());
        $this->assertEmpty($p->getOptions());

    }

    // public function testIsNull(){
    //     $p = new Property();
    // }
}
