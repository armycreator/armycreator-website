<?php

namespace armycreator\phpbb\event;

require(__DIR__ . '/../vendor/autoload.php');

use phpbb\auth\auth;
use phpbb\config\config;
use phpbb\event\data;
use phpbb\template\template;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\VarDumper\VarDumper\VarDumper;
use Symfony\Component\Yaml\Yaml;

/**
 * Class listener
 * @author Julien Deniau <julien.deniau@mapado.com>
 */
class listener implements EventSubscriberInterface
{
    private $template;

    private $config;

    public function __construct(template $template, config $config)
    {
        $this->template = $template;
        $this->config = $config;
    }

    public static function getSubscribedEvents()
    {
        return [
            'core.user_setup' => 'user_setup',
            'core.common' => 'common',
        ];
    }

    public function user_setup(data $event)
    {
        $user_data = $event->get_data()['user_data'];
        if ($user_data['is_registered'] && !$user_data['is_bot'])
        {
            $this->template->assign_vars([
                'user_data' => $user_data,
            ]);
        }
    }

    public function common($event)
    {
        $root = $this->config['armycreator_path'];
        if (!$root) {
            throw new \RuntimeException('armycreator_path must be set');
        }
        $filename_list = [
            $root . 'gassetic.dump.prod.yml',
            $root . 'gassetic.dump.dev.yml',
        ];

        $file_exists = false;
        foreach ($filename_list as $filename) {
            if (file_exists($filename)) {
                $file_exists = true;
                break;
            }
        }

        if (!$file_exists) {
            return;
        }


        $content_list = Yaml::parse(file_get_contents($filename));

        $out_css_files = [];
        $out_js_files = [];
        foreach ($content_list as $content) {
            if ($content['mimetype'] === 'css') {
                $css_files = array_merge(
                    $content['files']['global.css'],
                    $content['files']['forum.css']
                );
                foreach ($css_files as $css_file) {
                    $out_css_files[] = str_replace('%path%', $css_file, $content['htmlTag']);
                }
            } elseif ($content['mimetype'] === 'js') {
                $js_files = $content['files']['forum.js'];
                foreach ($js_files as $js_file) {
                    $out_js_files[] = str_replace('%path%', $js_file, $content['htmlTag']);
                }
            }
        }

        $this->template->assign_vars([
            'css_files' => $out_css_files,
            'js_files' => $out_js_files,
        ]);
    }
}
