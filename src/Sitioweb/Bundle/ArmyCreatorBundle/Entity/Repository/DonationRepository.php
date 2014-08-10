<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class DonationRepository extends EntityRepository
{
    public function findByCurrentYear()
    {
        return $this->findBy(['year' => date('Y')]);
    }
}
