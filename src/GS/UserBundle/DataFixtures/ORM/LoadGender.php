<?php

namespace GS\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use GS\UserBundle\Entity\Gender;

class LoadGender implements FixtureInterface
{
  // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
  public function load(ObjectManager $manager)
  {
    // Liste des noms de catégorie à ajouter
    $names = array(
        'Masculin',
        'Feminin'
    );

    foreach ($names as $name) {
      // On crée la catégorie
      $entity = new Gender();
      $entity->setName($name);

      // On la persiste
      $manager->persist($entity);
    }

    // On déclenche l'enregistrement de toutes les catégories
    $manager->flush();
  }
}
