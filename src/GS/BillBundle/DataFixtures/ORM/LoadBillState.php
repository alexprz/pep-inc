<?php
namespace GS\BillBundle\DataFixtures\ORM;

use GS\BillBundle\Entity\BillState;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadBillState extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $names = array(
            'Émise',
            'Payée',
            'Annulée'
        );

        foreach ($names as $name) {
          // On crée la catégorie
          $entity = new BillState();
          $entity->setName($name);

          // On la persiste
          $manager->persist($entity);
        }

        $manager->flush();
    }
}
