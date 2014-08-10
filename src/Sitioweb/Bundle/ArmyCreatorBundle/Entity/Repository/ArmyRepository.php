<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\User;

/**
 * ArmyRepository
 */
class ArmyRepository extends EntityRepository
{
    /**
     * findPublic
     *
     * @access public
     * @return Query
     */
    public function findPublicQueryBuilder(User $user = null)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('a')
            ->from('SitiowebArmyCreatorBundle:Army', 'a')
            ->orderBy('a.createDate', 'DESC')
            ->where('a.points > 0')
            ->andWhere('a.isShared = 1');

        if ($user) {
            $qb->andWhere('a.user = :user')
                ->setParameter('user', $user);
        }

        return $qb;
    }

    public function findPublic(User $user = null)
    {
        return $this->findPublicQueryBuilder($user)
            ->getQuery()
            ->getResult();
    }
}
