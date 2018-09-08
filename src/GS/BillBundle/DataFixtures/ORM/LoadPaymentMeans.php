<?php
namespace GS\BillBundle\DataFixtures\ORM;

use GS\BillBundle\Entity\PaymentMeans;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadPaymentMeans extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $names = array(
            'Chèque',
            'Virement'
        );

        foreach ($names as $name) {
          // On crée la catégorie
          $entity = new PaymentMeans();
          $entity->setName($name);

          // On la persiste
          $manager->persist($entity);
        }

        $manager->flush();
    }
}
