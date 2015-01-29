<?php

namespace Sitioweb\Bundle\ApiBundle\Controller;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * UserLinkController
 *
 * @uses Controller
 * @author Julien Deniau <julien.deniau@mapado.com>
 */
class UserLinkController extends FOSRestController
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
     * Get user army groups
     *
     * @param int $userId
     * @access public
     *
     * @ApiDoc(
     *     section="Users",
     *     description="get users army groups",
     *     requirements={
     *         { "name"="userId", "description"="User id", "dataType"="int" }
     *     }
     * )
     * @Rest\View()
     */
    public function getArmygroupsAction($userId)
    {
        $user = $this->retrieveUserOr404($userId);
        return ['data' => $user->getArmyGroupList()];
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

