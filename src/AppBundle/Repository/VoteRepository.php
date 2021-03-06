<?php

namespace AppBundle\Repository;

use AppBundle\Entity\User;
use AppBundle\Entity\Vote;

/**
 * VoteRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class VoteRepository extends \Doctrine\ORM\EntityRepository
{
    public function getQueryBuilderFindBy(User $user, $vote = '')
    {
        $queryBuilder = $this->createQueryBuilder('v')
          ->where('v.user=:user')
          ->setParameter(':user', $user);
        switch ($vote) {
            case 'yes':
                $queryBuilder->andWhere('v.vote=:vote')->setParameter(':vote', Vote::YES);
                break;
            case 'maybe':
                $queryBuilder->andWhere('v.vote=:vote')->setParameter(':vote', Vote::MAYBE);
                break;
            case 'no':
                $queryBuilder->andWhere('v.vote=:vote')->setParameter(':vote', Vote::NO);
                break;
        }
        return $queryBuilder;
    }
}
