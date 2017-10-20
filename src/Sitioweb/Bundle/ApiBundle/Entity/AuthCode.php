<?php

namespace Sitioweb\Bundle\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\OAuthServerBundle\Entity\AuthCode as BaseAuthCode;

/**
 * @ORM\Entity
 * @ORM\Table(name="oauth_auth_code")
 */
class AuthCode extends BaseAuthCode
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $client;

    /**
     * userId
     *
     * @var mixed
     * @access private
     *
     * @ORM\Column(name="user_id", type="integer")
     */
    private $userId;

    protected $user;

    /**
     * Getter for userId
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Setter for userId
     *
     * @param int $userId
     * @return AccessToken
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }
}
