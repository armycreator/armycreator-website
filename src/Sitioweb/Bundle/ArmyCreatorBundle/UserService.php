<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle;

use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Repository\SaveRepository;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\User;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Role\SwitchUserRole;

class UserService
{
    private $tokenStorage;

    private $userRepository;

    private $armyCreatorUser;

    public function __construct(
        TokenStorageInterface $tokenStorage,
        SaveRepository $userRepository
    ) {
        $this->tokenStorage = $tokenStorage;
        $this->userRepository = $userRepository;
    }

    /**
     * getUser
     *
     * @access public
     * @return User
     */
    public function getArmyCreatorUser()
    {
        if (!isset($this->armyCreatorUser)) {
            $this->armyCreatorUser = $this->fetchArmyCreatorUser();
        }

        return $this->armyCreatorUser !== false
            ? $this->armyCreatorUser
            : null;
    }

    private function fetchArmyCreatorUser()
    {
        // inspired by Symfony\Bundle\FrameworkBundle\Controller\Controller::getUser()
        if (!$this->tokenStorage) {
            throw new \LogicException('The SecurityBundle is not registered in your application.');
        }

        $token = $this->tokenStorage->getToken();

        if (null === $token) {
            return false;
        }

        $forumUser = $token->getUser();
        if (!is_object($forumUser)) {
            $forumUser = null;
        }
        // end of inspiration

        $isOriginalToken = $this->isOriginalToken($token);

        if ($forumUser && $isOriginalToken) {
            $currentUser = $this->userRepository
                ->findOneByEmail($forumUser->getEmail());

            if (!$currentUser) {
                $currentUser = new User();
            }

            $currentUser->setForumId($forumUser->getId());
            $currentUser->setUsername($forumUser->getUsername());
            $currentUser->setEmail($forumUser->getEmail());
            $lastLogin = new \DateTime();
            $currentUser->setLastLogin($lastLogin);

            $this->userRepository->save($currentUser);

            return $currentUser;
        } elseif (!$isOriginalToken) { // user is impersonated
            return $token->getUser();
        }

        return false;
    }

    /**
     * Gets the original Token from a switched one.
     *
     * @param TokenInterface $token A switched TokenInterface instance
     *
     * @return TokenInterface|false The original TokenInterface instance, false if the current TokenInterface is not switched
     */
    private function getOriginalToken(TokenInterface $token)
    {
        foreach ($token->getRoles() as $role) {
            if ($role instanceof SwitchUserRole) {
                return $role->getSource();
            }
        }

        return false;
    }

    /**
     * isOriginalToken
     *
     * @param TokenInterface $token
     * @access private
     * @return boolean
     */
    private function isOriginalToken(TokenInterface $token)
    {
        $originalToken = $this->getOriginalToken($token);

        return $originalToken === false || $token === $originalToken;
    }
}

