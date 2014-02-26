<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RedirectController extends Controller
{
    /**
     * redirect301Action
     *
     * @access public
     * @return void
     */
    public function redirect301Action($oldRoute)
    {
        if (substr($oldRoute, 0, 1) != '/') {
            $oldRoute = '/' . $oldRoute;
        }

        $urlList = [
            '/toolbox/dice_launch\.html' => '/toolbox/',
            '/toolbox/dice_tir\.html' => '/toolbox/weapon',
            '/toolbox/dice_cac\.html' => '/toolbox/infight',
            '/joueurs-disponibles\.html' => '/', // todo page a faire
            '/race_list\.html' => '/admin/breed/W40K',
            '/equipement_list\.html' => '/admin/breed/W40K',
            '/weapon_list\.html' => '/admin/breed/W40K',
            '/race/([0-9]+)-(.*)\.html$' => '/admin/breed/W40K',
            '/tableaux_bord\.html' => '/admin/game/', // todo page a faire
            '/armees-(types|brouillons)\.html' => '/army/',
            '/armees-(types|brouillons)/([0-9]+)-(.*)\.html' => '/army/group/$2',
            '/army-([0-9]+)-(.*)/bb_code_print\.html' => '/army/army-$1',
            '/army-([0-9]+)-(.*)/army_print\.html' => '/army/army-$1',
            '/army-([0-9]+)-(.*)/bb_code\.html' => '/army/army-$1/bbcode',
            '/army-([0-9]+)-(.*)\.html' => '/army/army-$1',

            '/my-combat-list\.html' => '/',
            '/army-list-([0-9]+)-(.*)\.html' => '/',

            '/collection\.html' => '/collection',
            '/collection/([0-9]+)-(.*)\.html' => '/collection',
        ];

        foreach ($urlList as $old => $new) {
            if (preg_match('#^' . $old . '$#', $oldRoute)) {
                $newRoute = preg_replace('#^' . $old . '$#', $new, $oldRoute);
                return $this->redirect($newRoute, 301);
            }
        }

        throw $this->createNotFoundException('Unable to redirect the following url: "' . $oldRoute . '"');
    }
}
