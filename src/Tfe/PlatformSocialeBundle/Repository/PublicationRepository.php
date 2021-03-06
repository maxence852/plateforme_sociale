<?php

namespace Tfe\PlatformSocialeBundle\Repository;
use Doctrine\ORM\Query\ResultSetMapping;
use Tfe\PlatformSocialeBundle\Entity\Publication;

/**
 * PublicationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PublicationRepository extends \Doctrine\ORM\EntityRepository
{

    public function ResearchKeywords($keywords)
    {
        $qb = $this->createQueryBuilder('a');
        $qb->where("a.motsCles like '%".$keywords[0]."%'");
        for($i=1; $i<sizeof($keywords); $i++){
            $qb->orWhere("a.motsCles like '%".$keywords[$i]."%'");
        }
        return $qb
            ->getQuery()
            ->getResult()
            ;
    }
    public function getAllOrderedPublications($em)
    {
        $rsm = new ResultSetMapping($em);
        $rsm->addEntityResult('Tfe\PlatformSocialeBundle\Entity\Publication', 'p');
        $rsm->addFieldResult('p', 'id', 'id');
        $rsm->addFieldResult('p', 'titrePublication', 'titrePublication');
        $rsm->addFieldResult('p', 'contentPublication', 'contentPublication');
        $rsm->addJoinedEntityResult('Tfe\UserBundle\Entity\Users', 'u', 'p', 'user');
        $rsm->addFieldResult('u', 'id', 'id');
        $rsm->addFieldResult('u', 'username', 'username');
        $q  = "select titrePublication,contentPublication, user_id, u.id, u.username, 'A' as suiveur from publication as p LEFT JOIN tfe_users as u ON u.id = 10 where p.user_id IN (select suiviId from abonnement_user where suiveurId =";
        $q .= " 10)";
        //$q .= " UNION ";
        //$q .= "select titrePublication,contentPublication, user_id, 'B'  from publication as p where p.user_id NOT IN (select suiviId from abonnement_user where suiveurId = ";
        //$q .= "10) ORDER BY suiveur ASC";
        $query = $em->createNativeQuery($q, $rsm);
        return $query
            ->getArrayResult();
    }

    public function findbyidperso($request)
    {
        $qb = $this->createQuery('SELECT titrepublication FROM publication where id = '.$request.' ');
        //$qb->where("a.id= $request ");

        return $qb
            //->getQuery()
            ->getResult()
            ;
    }
}
