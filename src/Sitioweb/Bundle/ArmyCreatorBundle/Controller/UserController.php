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
     * indexAction
     *
     * @param User $user
     * @access public
     * @return Response
     *
     * @Route("/user/{user}", name="user_index")
     * @ParamConverter("user", class="SitiowebArmyCreatorBundle:User", options={"mapping": {"user" = "slug"}})
     * @Template()
     */
    public function indexAction(User $user)
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
