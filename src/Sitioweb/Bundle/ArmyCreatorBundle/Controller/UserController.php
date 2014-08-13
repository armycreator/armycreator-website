<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Controller;

use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sitioweb\Bundle\ArmyCreatorBundle\Entity\User;

/**
 * User controller.
 *
 * @Breadcrumb("breadcrumb.home", route="homepage")
 */
class UserController extends Controller
{
    /**
     * listAction
     *
     * @access public
     * @return Response
     *
     * @Route("/user/", name="user_list")
     * @Breadcrumb("breadcrumb.users.list")
     * @Template()
     */
    public function listAction()
    {
        $userList = $this->get('doctrine.orm.default_entity_manager')
            ->getRepository('SitiowebArmyCreatorBundle:User')
            ->findByWantToPlay(true);

        return [
            'userList' => $userList,
        ];
    }

    /**
     * viewAction
     *
     * @param User $user
     * @access public
     * @return Response
     *
     * @Route("/user/{userSlug}", name="user_index")
     * @ParamConverter("user", class="SitiowebArmyCreatorBundle:User", options={"mapping": {"userSlug" = "slug"}})
     * @Breadcrumb("breadcrumb.users.list", routeName="user_list")
     * @Breadcrumb("{user}")
     * @Template()
     */
    public function viewAction(User $user)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');
        $publicArmyList = $em->getRepository('SitiowebArmyCreatorBundle:Army')
            ->findPublic($user);

        return [
            'user' => $user,
            'publicArmyList' => $publicArmyList,
        ];
    }
}
