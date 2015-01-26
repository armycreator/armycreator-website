<?php

namespace Sitioweb\Bundle\ApiBundle\Controller;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * ArmyController
 *
 * @uses Controller
 * @author Julien Deniau <julien.deniau@mapado.com>
 */
class ArmyController extends FOSRestController
{
    /**
     * Get User armies
     *
     * @ApiDoc(
     *     section="Armies",
     *     description="get users armies",
     *     requirements={
     *         { "name"="userId", "description"="User id", "dataType"="int" }
     *     }
     * )
     * @Rest\View()
     */
    public function getArmiesAction($userId)
    {
        $user = $this->retrieveUserOr404($userId);
        return ['data' => $user->getArmyList()];
    }

    /**
     * getAction
     *
     * @access public
     * @return void
     *
     * @ApiDoc(
     *     section="Armies",
     *     description="Get an army"
     * )
     * @Rest\View()
     */
    public function getArmyAction($id)
    {
        $army = $this->get('doctrine.orm.default_entity_manager')
            ->getRepository('SitiowebArmyCreatorBundle:Army')
            ->find($id);

        return $army;
    }

   /**
    * Return an user or throw a 404 Exception
    */
    private function retrieveUserOr404($userId)
    {
        $userManager = $this->get('fos_user.user_manager');

        $user = $userManager->findUserBy(['id' => $userId]);

        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }

        return $user;
    }
}
