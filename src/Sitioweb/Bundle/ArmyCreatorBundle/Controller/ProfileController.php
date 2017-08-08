<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Controller;

use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;
use JMS\SecurityExtraBundle\Annotation as Security;
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
 * @Security\PreAuthorize("isFullyAuthenticated()")
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
     * @Breadcrumb("breadcrumb.users.list")
     * @Breadcrumb("breadcrumb.profile.edit")
     * @Template()
     */
    public function editAction(Request $request)
    {
        $user = $this->getUser();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $this->get('doctrine.orm.default_entity_manager')
                    ->flush();
            }

            $url = $this->generateUrl('user_index', ['userSlug' => $user->getSlug()]);
            return $this->redirect($url);
        }

        $this->get('apy_breadcrumb_trail')->add(
            (string) $user,
            'user_index',
            ['userSlug' =>  $user->getSlug()],
            false,
            -1
        );

        return [
            'user' => $user,
            'form' => $form->createView(),
        ];
    }
}
