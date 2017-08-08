<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
