<?php

namespace Sitioweb\Bundle\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\OAuthServerBundle\Entity\AuthCode as BaseAuthCode;
use phpBB\SessionsAuthBundle\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;

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

    /**
     * Getter for user
     *
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Setter for user
     *
     * @param string $user
     * @return AccessToken
     */
    public function setUser(UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new \InvalidArgumentException('user must be instance of ' . User::class);
        }

        $this->user = $user;
        $this->setUserId($user->getId());

        return $this;
    }
}
