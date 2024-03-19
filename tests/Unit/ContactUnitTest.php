<?php

namespace App\Tests\Unit;

use App\Entity\Contact;
use PHPUnit\Framework\TestCase;

class ContactUnitTest extends TestCase
{
    public function testIsTrue(): void
    {
        $c = new Contact();
        $c 
            ->setFirstname('firstname')
            ->setLastname("lastname")
            ->setEmail("email@gmail.com")
            ->setMessage("message")
            ->setPhone(0000000000)
        ;


        $this->assertTrue($c->getFirstname() == "firstname");
        $this->assertTrue($c->getLastname() == "lastname");
        $this->assertTrue($c->getEmail() == "email@gmail.com");
        $this->assertTrue($c->getMessage() == "message");
        $this->assertTrue($c->getPhone() == 0000000000);
    }

}
