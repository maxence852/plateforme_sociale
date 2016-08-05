<?php

namespace Tfe\ForumBundle\Repository;
use Doctrine\ORM\EntityRepository;

/**
 * GroupRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class GroupRepository extends EntityRepository
{
    /*public function getAdvertsBefore(\Datetime $date)
    {
        return $this->createQueryBuilder('a')
            ->where('a.updatedAt <= :date')                      // Date de modification antérieure à :date
            ->orWhere('a.updatedAt IS NULL AND a.date <= :date') // Si la date de modification est vide, on vérifie la date de création
            ->andWhere('a.applications IS EMPTY')                // On vérifie que l'annonce ne contient aucune candidature
            ->setParameter('date', $date)
            ->getQuery()
            ->getResult()
            ;
    }*/

    public function myFindAll()
    {
/*
         // Méthode 1 : en passant par l'EntityManager
        $queryBuilder = $this->_em->createQueryBuilder()
            ->select('id','title')
            ->from($this->_entityName, 'gr')
            ->orderBy('title', 'ASC')
        ;
        // Dans un repository, $this->_entityName est le namespace de l'entité gérée
        // Ici, il vaut donc Test\PlatformBundle\Entity\Advert
        // Méthode 2 : en passant par le raccourci (je recommande)
        $queryBuilder = $this->createQueryBuilder('gr');
        // On n'ajoute pas de critère ou tri particulier, la construction
        // de notre requête est finie
        // On récupère la Query à partir du QueryBuilder
        $query = $queryBuilder->getQuery();
        // On récupère les résultats à partir de la Query
        $results = $query->getResult();
        // On retourne ces résultats
        return $results;
*/

        $qb = $this->createQueryBuilder('a');

        $qb->select('a.title,a.id');

        $qb->orderBy('a.title', 'ASC');

        return $qb
            ->getQuery()
            ->getResult()
            ;


    }
}
