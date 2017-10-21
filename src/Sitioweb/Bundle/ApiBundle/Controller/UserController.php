<?php

namespace Sitioweb\Bundle\ApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * UserController
 *
 * @uses Controller
 * @author Julien Deniau <julien.deniau@mapado.com>
 */
class UserController extends FOSRestController
{
    /**
     * getAction
     *
     * @access public
     * @return void
     *
     * @ApiDoc(
     *     section="Users",
     *     desccription="Get the current user"
     * )
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     */
    public function getMeAction()
    {
        return $this->get('user_service')->getArmyCreatorUser();
    }

    /**
     * getUserAction
     *
     * @param mixed $id
     * @access public
     * @return void
     *
     * @ApiDoc(
     *     section="Users",
     *     description="Get a user",
     *     requirements={
     *         { "name"="userId", "description"="user id", "dataType"="integer" }
     *     }
     * )
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     */
    public function getUserAction($userId)
    {
        $userRepo = $this->get('armycreator.repository.user');

        $user = $userRepo->find($userId);

        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }

        return $user;
    }
}
