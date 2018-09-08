<?php
namespace GS\BillBundle\DataFixtures\ORM;

use GS\BillBundle\Entity\BillType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadBillType extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $names = array(
            'Facture de vente',
            'Refacturation'
        );

        foreach ($names as $name) {
          // On crée la catégorie
          $entity = new BillType();
          $entity->setName($name);

          // On la persiste
          $manager->persist($entity);
        }

        $manager->flush();
    }
}
