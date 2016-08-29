<?php

namespace Tfe\ForumBundle\Repository;

/**
 * CommentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CommentRepository extends \Doctrine\ORM\EntityRepository
{
    public function myFindAllComments($thread)
    {
        $qb = $this->createQueryBuilder('a');

        //$qb->select('a.title,a.id');
        $qb->where('a.thread = :thread')
            ->setParameter('thread', $thread)
            ->orderBy('a.createdAt', 'ASC');

        return $qb
            ->getQuery()
            ->getResult()
            ;
    }
}
