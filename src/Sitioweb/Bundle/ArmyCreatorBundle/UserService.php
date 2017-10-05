<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle;

use FOS\UserBundle\Doctrine\UserManager;
use FOS\UserBundle\Security\LoginManager;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Role\SwitchUserRole;

class UserService
{
    private $kernelRootDir;

    private $tokenStorage;

    private $userManager;

    private $loginManager;

    public function __construct($kernelRootDir, TokenStorageInterface $tokenStorage, UserManager $userManager, LoginManager $loginManager)
    {
        $this->kernelRootDir = $kernelRootDir;
        $this->tokenStorage = $tokenStorage;
        $this->userManager = $userManager;
        $this->loginManager = $loginManager;
    }

    /**
     * onKernelController
     *
     * @param FilterControllerEvent $event
     * @access public
     * @return void
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        return;
        $controllerClass = get_class($event->getController()[0]);

        if (strpos($controllerClass, 'ApiBundle') !== false) {
            return;
        }

        $this->getUser();
    }

    /**
     * getUser
     *
     * @access public
     * @return User
     */
    public function getUser()
    {
        // inspired by Symfony\Bundle\FrameworkBundle\Controller\Controller::getUser()
        if (!$this->tokenStorage) {
            throw new \LogicException('The SecurityBundle is not registered in your application.');
        }

        $token = $this->tokenStorage->getToken();

        if (null === $token) {
            return null;
        }

        $forumUser = $token->getUser();
        if (!is_object($forumUser)) {
            $forumUser = null;
        }
        // end of inspiration

        $isOriginalToken = $this->isOriginalToken($token);

        if ($forumUser && $isOriginalToken) {
            $currentUser = $this->userManager->findUserByEmail($forumUser->getEmail());
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
            $this->loginManager->loginUser('main', $currentUser);


            return $currentUser;
        } elseif (!$isOriginalToken) {
            return $token->getUser();
        } else {
            $anonymousToken = new AnonymousToken('main', 'anon.');
            $this->tokenStorage->setToken($anonymousToken);

            return $token->getUser();
            //$this->get('fos_user.security.login_manager')->loginUser('main', null);
        }


        return;
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
        //ld($token, $originalToken);

        return $originalToken === false || $token === $originalToken;
    }
}

