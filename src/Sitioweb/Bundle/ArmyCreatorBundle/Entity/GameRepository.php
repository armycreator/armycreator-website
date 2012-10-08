<?php
namespace Sitioweb\Bundle\ArmyCreatorBundle\Entity;

use Doctrine\ORM\EntityRepository;

class GameRepository extends EntityRepository
{
    /**
     * findByCode
     *
     * @param string $code
     * @access public
     * @return void
     */
    public function findByCode($code)
    {
		return $this->findOneBy(array('code' => $code));
    }
}
