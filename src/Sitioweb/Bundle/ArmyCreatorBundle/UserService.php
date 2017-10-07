<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle;

use FOS\UserBundle\Doctrine\UserManager;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Role\SwitchUserRole;

class UserService
{
    private $tokenStorage;

    private $userManager;

    private $armyCreatorUser;

    public function __construct(
        TokenStorageInterface $tokenStorage,
        UserManager $userManager
    ) {
        $this->tokenStorage = $tokenStorage;
        $this->userManager = $userManager;
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
            $currentUser = $this->userManager
                ->findUserByEmail($forumUser->getEmail());

            if (!$currentUser) {
                $currentUser = $this->userManager->createUser();
            }

            $currentUser->setForumId($forumUser->getId());
            $currentUser->setUsername($forumUser->getUsername());
            $currentUser->setEmail($forumUser->getEmail());
            $currentUser->setPlainPassword($forumUser->getPassword());
            $lastLogin = new \DateTime();
            // $lastLogin->setTimestamp($user->data['user_lastvisit']);
            $currentUser->setLastLogin($lastLogin);
            $currentUser->setEnabled(true);
            // $currentUser->setAvatar($user->data['user_avatar']);

            $this->userManager->updateUser($currentUser);

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

