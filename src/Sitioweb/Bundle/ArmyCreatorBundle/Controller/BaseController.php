<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController extends Controller
{

    /**
     * getUser
     *
     * @access public
     * @return User
     */
    public function getUser ()
    {
        global $db, $template, $config, $auth, $phpEx, $phpbb_root_path, $cache;
        define('IN_PHPBB', true);
        //define('PHPBB_ROOT_PATH', 'forum');
        $phpbb_root_path = 'forum/';
        $phpEx = 'php';
        require($this->get('kernel')->getRootDir() . '/../web/forum/common.php');
        $user->session_begin();
        $auth->acl($user->data);
        //$user->setup();

        $currentUser = parent::getUser();
        if ($user->data['is_registered']) {
            if (!$currentUser || $user->data['user_id'] != $currentUser->getForumId()) {
                $currentUser = $this->get('fos_user.user_manager')->findUserByUsername($user->data['username']);
                if (!$currentUser) {
                    $currentUser = $this->get('fos_user.user_manager')->createUser();
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
                $this->get('fos_user.user_manager')->updateUser($currentUser);
                $this->get('fos_user.security.login_manager')->loginUser('main', $currentUser);
            }

            return $currentUser;
        } elseif ($currentUser) {
            $anonymousToken = new \Symfony\Component\Security\Core\Authentication\Token\AnonymousToken('main', 'anon.');
            $this->container->get('security.context')->setToken($anonymousToken);
            //$this->container->get('security.context')->getToken()->setUser('anon.');
            return $this->container->get('security.context')->getToken()->getUser();
            //return $this->redirect($this->generateUrl('fos_user_security_logout'));
            //$this->get('fos_user.security.login_manager')->loginUser('main', null);
        }
    }
}

