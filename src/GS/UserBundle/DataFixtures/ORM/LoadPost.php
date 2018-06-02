<?php

namespace GS\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use GS\UserBundle\Entity\Post;

class LoadPost implements FixtureInterface
{
  // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
  public function load(ObjectManager $manager)
  {
    // Liste des noms de catégorie à ajouter
    $names = array(
        'Président',
        'Vice-Président',
        'Secrétaire Général',
        'Trésorier',
        'Vice-Trésorier',
        'Directeur Études',
        'Directeur Qualité',
        'DESI',
        'Directeur Commercial',
        'Responsable Appels d\'offre',
        'Responsable Communication & Événementiels'
    );

    foreach ($names as $name) {
      // On crée la catégorie
      $entity = new Post();
      $entity->setName($name);

      // On la persiste
      $manager->persist($entity);
    }

    // On déclenche l'enregistrement de toutes les catégories
    $manager->flush();
  }
}
