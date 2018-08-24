<?php
namespace GS\MailerBundle\DataFixtures\ORM;

use GS\MailerBundle\Entity\Specialization;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadSpecializations extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $names = array(
            'Génie Mécanique',
            'Génie Civil',
            'Énergie, Transports et Urbanisme',
            'Stratégie, Finance et Économie',
            'Génie Industriel et Marketing',
            'Informatique',
            'Traduction technique'
        );

        $i = 0;

        foreach ($names as $name) {
          // On crée la catégorie
          $entity = new Specialization();
          $entity->setName($name);
          $entity->setSortCode($i);
          $i ++;

          // On la persiste
          $manager->persist($entity);
        }


        $manager->flush();
    }
}
