<?php


namespace Evrinoma\ContractorBundle\Fixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Evrinoma\ContractorBundle\Entity\Basic\BaseContractor;

class ContractorFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $contractor1 = new BaseContractor();
        $contractor2 = new BaseContractor();
        $contractor3 = new BaseContractor();
        $contractor4 = new BaseContractor();
        $contractor5 = new BaseContractor();
        $contractor6 = new BaseContractor();
        $manager->persist($contractor1);
        $manager->persist($contractor2);
        $manager->persist($contractor3);
        $manager->persist($contractor4);
        $manager->persist($contractor5);
        $manager->persist($contractor6);
        $manager->flush();
    }
}
