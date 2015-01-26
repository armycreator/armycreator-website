<?php

namespace Sitioweb\Bundle\ApiBundle\Oauth;

use FOS\OAuthServerBundle\Storage\OAuthStorage as BaseOAuthStorage;
use OAuth2\Model\IOAuth2Client;

class OauthStorage extends BaseOAuthStorage
{
    /**
     * rootDir
     *
     * @var string
     * @access private
     */
    private $rootDir;

    /**
     * setRootDir
     *
     * @param mixed $rootDir
     * @access public
     * @return OauthStorage
     */
    public function setRootDir($rootDir)
    {
        $this->rootDir = $rootDir;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function checkUserCredentials(IOAuth2Client $client, $username, $password)
    {
        $password = $this->phpbbPassword($username, $password);
        return parent::checkUserCredentials($client, $username, $password);
    }

    /**
     * phpbbPassword
     *
     * @param string $password
     * @access private
     */
    private function phpbbPassword($username, $password)
    {
        $phpbb_root_path = 'forum/';
        $phpEx = 'php';
        require_once($this->rootDir . '/../web/forum/common.php');


        $userLogin = login_db($username, $password);


        if ($userLogin['status'] !=  LOGIN_SUCCESS) {
            // login failed, return the password that will failed after no transformation
            return $password;
        } else {
            return $userLogin['user_row']['user_password'];
        }
    }
}
