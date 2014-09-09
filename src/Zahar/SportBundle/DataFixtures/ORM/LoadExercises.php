<?php
namespace Zahar\SportBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Nelmio\Alice\Fixtures;

class LoadExercises implements FixtureInterface
{

    public function load(ObjectManager $om)
    {
        // pass $this as an additional faker provider to make the "groupName"
        // method available as a data provider
        $objects = Fixtures::load(__DIR__.'/fixtures.yml', $om);
        $persister = new \Nelmio\Alice\ORM\Doctrine($om);
        $persister->persist($objects);
    }

}