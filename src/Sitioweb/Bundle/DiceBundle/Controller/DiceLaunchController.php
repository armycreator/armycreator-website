<?php

namespace Sitioweb\Bundle\DiceBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sitioweb\Bundle\DiceBundle\Form;
use Sitioweb\Bundle\DiceBundle\Model;

/**
 * dice launch controller.
 */
class DiceLaunchController extends Controller
{

    /**
     * dice launcher
     *
     * @Route("/", name="toolbox_dice")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        // get default
        $defaultDices = new Model\DiceLaunch();
        $dices = $defaultDices;

        $form = $this->createForm(new Form\DiceType(), $dices);

        // the user submitted the form
        if ($request->getMethod() === 'POST') {
            $form->bind($request);

            if (!$form->isValid()) {
                $dices = $defaultDices;
            } else {
                $nbDices = $dices->getDiceNumber();

                $resultList = array();
                for ($i = 1; $i <= 6; $i++) {
                    $resultList[$i] = 0;
                    $supList[$i] = 0;
                }

                for ($i = 0; $i < $nbDices; $i++) {
                    $rand = mt_rand(1, 6);
                    $resultList[$rand]++;
                    for ($j = 1; $j <= $rand; $j++) {
                        $supList[$j]++;
                    }
                }
            }

        }

        return array(
            'dices' => $dices,
            'resultList' => $resultList,
            'supList' => $supList,
            'form' => $form->createView()
        );
    }

    /**
     * weaponStatisticAction
     *
     * @access public
     * @return void
     *
     * @Route("/weapon", name="toolbox_weapon_statistic")
     * @Template()
     */
    public function weaponStatisticAction()
    {
        // get default
        $defaultShots = new Model\ShotFired();
        $shots = $defaultShots;

        $form = $this->createForm(new Form\ShotFiredType(), $shots);

        $request = $this->getRequest();
        if ($request->getMethod() === 'POST') {
            $form->bind($request);

            if (!$form->isValid()) {
                $shots = $defaultShots;
            }
        }

        return array(
            'shots' => $shots,
            'form' => $form->createView()
        );
    }

    /**
     * infightStatisticAction
     *
     * @access public
     * @return void
     *
     * @Route("/infight", name="toolbox_infight_statistic")
     * @Template()
     */
    public function infightStatisticAction()
    {
        // get default
        $default = new Model\Infight();
        $items = $default;

        $form = $this->createForm(new Form\InfightType(), $items);

        $request = $this->getRequest();
        if ($request->getMethod() === 'POST') {
            $form->bind($request);

            if (!$form->isValid()) {
                $items = $default;
            }
        }

        return array(
            'infight' => $items,
            'form' => $form->createView()
        );
    }
}
