<?php

namespace Sitioweb\Bundle\ApiBundle\Controller;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

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
        return $this->get('security.context')->getToken()->getUser();
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
        $userManager = $this->get('fos_user.user_manager');

        $user = $userManager->findUserBy([
            'id' => $userId
        ]);

        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }

        return $user;
    }
}
