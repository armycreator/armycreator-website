<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * DonationController
 */
class DonationController extends Controller
{
    /**
     * widgetAction
     *
     * @access public
     * @return Response
     *
     * @Template
     */
    public function widgetAction()
    {
        $donationList = $this->get('doctrine')
            ->getRepository('SitiowebArmyCreatorBundle:Donation')
            ->findByCurrentYear();

        $total = 0;
        foreach ($donationList as $donation) {
            $total += $donation->getAmount();
        }

        return [
            'nbDonations' => count($donationList),
            'totalAmount' => $total,
        ];
    }
}
