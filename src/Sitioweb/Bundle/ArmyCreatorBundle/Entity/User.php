<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * Sitioweb\Bundle\ArmyCreatorBundle\Entity\User
 *
 * @ORM\Table(name="Users")
 * @ORM\Entity
 */
class User extends BaseUser
{
    /**
     * id
     * 
     * @var integer
     * @access protected
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * forumId
     * 
     * @var mixed
     * @access protected
     *
     * @ORM\Column(type="integer")
     */
    protected $forumId;

    /**
     * Gets the value of forumId
     *
     * @return int
     */
    public function getForumId()
    {
        return $this->forumId;
    }
    
    /**
     * Sets the value of forumId
     *
     * @param int $forumId
     * @return self
     */
    public function setForumId($forumId)
    {
        $this->forumId = $forumId;
        return $this;
    }

}
