<?php

namespace Sitioweb\Bundle\ApiBundle\Controller;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * UserArmyController
 *
 * @uses Controller
 * @author Julien Deniau <julien.deniau@mapado.com>
 */
class UserArmyController extends FOSRestController
{
    /**
     * Get User armies
     *
     * @ApiDoc(
     *     section="Users",
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
