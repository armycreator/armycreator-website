<?php

namespace Sitioweb\Bundle\ApiBundle\Controller;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;

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
     *         { "name"="userId", "description"="User id", "dataType"="int" },
     *     }
     * )
     * @QueryParam(name="page", requirements="\d+", default="1", description="Page of the view")
     * @QueryParam(name="limit", requirements="\d+", default="10", description="Limit of items")
     * @Rest\View(serializerGroups={"List", "BaseArmy"})
     */
    public function getArmiesAction($userId, ParamFetcher $paramFetcher)
    {
        $page = (int) $paramFetcher->get('page');
        $limit = (int) $paramFetcher->get('limit');
        $user = $this->retrieveUserOr404($userId);
        $armyList = $user->getArmyList();

        $em = $this->get('doctrine.orm.default_entity_manager');
        $query = $em->getRepository('SitiowebArmyCreatorBundle:Army')
            ->findByUser($user, ['updateDate' => 'DESC']);

        $armyList = $this->get('knp_paginator')
            ->paginate($query, $page, $limit);

        return [
            'current_page_number' => $armyList->getCurrentPageNumber(),
            'num_items_per_page' => $armyList->getItemNumberPerPage(),
            'total_count' => $armyList->getTotalItemCount(),
            'items' => $armyList->getItems(),
        ];
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

