<?php

namespace App\Tests\Unit\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\Colleague;

class ColleagueTest extends TestCase
{
    public function testSettingColleagueName()
    {
        $name = 'John Doe';
        $colleague = new Colleague();
        $colleague->setName($name);
        $this->assertEquals($name, $colleague->getName());
    }

    public function testSettingColleagueEmail()
    {
        $email = 'admin@example.com';
        $colleague = new Colleague();
        $colleague->setEmail($email);
        $this->assertEquals($email, $colleague->getEmail());
    }

    public function testSettingColleagueNote()
    {
        $note = 'This is test note.';
        $colleague = new Colleague();
        $colleague->setNote($note);
        $this->assertEquals($note, $colleague->getNote());
    }

    public function testSettingColleagueCreated()
    {
        $dateTime = new \DateTime();
        $colleague = new Colleague();
        $colleague->setCreated($dateTime);
        $this->assertEquals($dateTime, $colleague->getCreated());
    }

    public function testSettingColleagueUpdated()
    {
        $dateTime = new \DateTime();
        $colleague = new Colleague();
        $colleague->setUpdated($dateTime);
        $this->assertEquals($dateTime, $colleague->getUpdated());
    }
}
