<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class AdsController
{
    /**
     * render
     *
     * @param mixed $slot
     * @param int $width
     * @param int $height
     * @access public
     * @return void
     *
     * @Template
     */
    public function renderAction($type = 'square')
    {
        switch ($type) {
            case 'banner':
                $slot = '7635175121';
                $width = 728;
                $height = 90;

                break;

            case 'mobile':
                $slot = '6540708410';
                $width = 320;
                $height = 50;

                break;

            default:
                $slot = '8956457418';
                $width = 300;
                $height = 250;

                break;
        }

        return ['slot' => $slot, 'width' => $width, 'height' => $height];
    }
}
