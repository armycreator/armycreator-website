<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Controller;

use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Sitioweb\Bundle\ArmyCreatorBundle\Entity\User;
use Sitioweb\Bundle\ArmyCreatorBundle\Form\UserType;

/**
 * User controller.
 *
 * @Breadcrumb("breadcrumb.home", route="homepage")
 */
class ProfileController extends Controller
{
    /**
     * indexAction
     *
     * @param User $user
     * @access public
     * @return Response
     *
     * @Route("/profile/edit", name="profile_edit")
     * @Template()
     */
    public function editAction(Request $request)
    {
        $user = $this->getUser();

        $form = $this->createForm(new UserType, $user);

        if ($request->isMethod("POST")) {
            $form->bind($request);
            if ($form->isValid()) {
                $this->get('doctrine.orm.default_entity_manager')
                    ->flush();
            }

            $url = $this->generateUrl('user_index', ['user' => $user->getSlug()]);
            return $this->redirect($url);
        }


        return [
            'user' => $user,
            'form' => $form->createView(),
        ];
    }
}
