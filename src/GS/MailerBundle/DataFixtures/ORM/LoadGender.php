<?php
namespace GS\MailerBundle\DataFixtures\ORM;

use GS\MailerBundle\Entity\Gender;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadGender extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $names = array(
            'Monsieur',
            'Madame'
        );

        $i = 0;

        foreach ($names as $name) {
          // On crée la catégorie
          $entity = new Gender();
          $entity->setName($name);
          $entity->setSortCode($i);
          $i ++;

          // On la persiste
          $manager->persist($entity);
        }


        $manager->flush();
    }
}
