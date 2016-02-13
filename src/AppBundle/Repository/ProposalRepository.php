<?php

namespace AppBundle\Repository;

use AppBundle\Entity\User;

/**
 * ProposalRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProposalRepository extends \Doctrine\ORM\EntityRepository
{
    public function findTodoBy(User $user)
    {
        $sub = $this->_em->createQueryBuilder();
        $sub->select('identity(v.proposal)')
            ->from('AppBundle:Vote', 'v')
            ->where($sub->expr()->eq('v.user', $user->getId()));
        $qb  = $this->_em->createQueryBuilder();
        $proposals = $qb->select('p')
            ->from('AppBundle:Proposal', 'p')
            ->where($qb->expr()->notIn('p', $sub->getDQL()));
        return $proposals->getQuery()->getResult();
    }
}
