<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;


class UserService
{
    /**
     * onKernelController
     *
     * @param FilterControllerEvent $event
     * @access public
     * @return void
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        $container = $event->getDispatcher()->getContainer();
        $this->getUser($container);
    }

    /**
     * getUser
     *
     * @access public
     * @return User
     */
    public function getUser ($container)
    {
        global $db, $template, $config, $auth, $phpEx, $phpbb_root_path, $cache;
        define('IN_PHPBB', true);
        //define('PHPBB_ROOT_PATH', 'forum');
        $phpbb_root_path = 'forum/';
        $phpEx = 'php';
        require($container->get('kernel')->getRootDir() . '/../web/forum/common.php');
        $user->session_begin();
        $auth->acl($user->data);
        //$user->setup();

        // inspired by Symfony\Bundle\FrameworkBundle\Controller\Controller::getUser()
        if (!$container->has('security.context')) {
            throw new \LogicException('The SecurityBundle is not registered in your application.');
        }

        if (null === $token = $container->get('security.context')->getToken()) {
            return null;
        }
        $currentUser = $token->getUser();
        if (!is_object($currentUser)) {
            $currentUser = null;
        }
        // end of inspiration

        if ($user->data['is_registered']) {
            if (!$currentUser || $user->data['user_id'] != $currentUser->getForumId()) {
                $currentUser = $container->get('fos_user.user_manager')->findUserByUsername($user->data['username']);
                if (!$currentUser) {
                    $currentUser = $container->get('fos_user.user_manager')->createUser();
                }
                $currentUser->setForumId($user->data['user_id']);
                $currentUser->setUsername($user->data['username']);
                $currentUser->setEmail($user->data['user_email']);
                $currentUser->setPlainPassword($user->data['user_password']);
                $lastLogin = new \DateTime();
                $lastLogin->setTimestamp($user->data['user_lastvisit']);
                $currentUser->setLastLogin($lastLogin);
                $currentUser->setEnabled($user->data['is_registered']);
                $currentUser->setLocked(false);
                $container->get('fos_user.user_manager')->updateUser($currentUser);
                $container->get('fos_user.security.login_manager')->loginUser('main', $currentUser);
            }
            

            return $currentUser;
        } elseif ($currentUser) {
            $anonymousToken = new \Symfony\Component\Security\Core\Authentication\Token\AnonymousToken('main', 'anon.');
            $container->get('security.context')->setToken($anonymousToken);
            
            return $container->get('security.context')->getToken()->getUser();
            //$this->get('fos_user.security.login_manager')->loginUser('main', null);
        }
    }
}

