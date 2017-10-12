<?php

namespace armycreator\phpbb\event;

require(__DIR__ . '/../vendor/autoload.php');

use phpbb\auth\auth;
use phpbb\config\config;
use phpbb\template\template;
use phpbb\user;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\VarDumper\VarDumper\VarDumper;

/**
 * Class listener
 * @author Julien Deniau <julien.deniau@mapado.com>
 */
class listener implements EventSubscriberInterface
{
    private $auth;

    private $user;

    public function __construct(config $config, auth $auth, user $user, template $template)
    {
        // var_dump($auth, $user);die;
        $this->config = $config;
        $this->auth = $auth;
        $this->user = $user;
        $this->template = $template;
    }

    public static function getSubscribedEvents()
    {
        return [
            'core.user_setup' => 'test',
            // 'core.user_setup' => 'user_setup',
            // 'core.login_box_failed' => 'login_box_failed',
        ];
    }

    public function test($event)
    {
        // dump($event, $this->auth, $this->user);
        if ($this->user->data['is_registered'] && !$this->user->data['is_bot'])
        {
            // $version = phpbb_version_compare($this->config['version'], '3.2.0-b2', '>=');
            $this->template->assign_vars(array(
                'user_data' => $this->user->data,
            ));
        }
    }
}
