<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * ArmyController
 * 
 * @uses BaseController
 * @Route("/army")
 *
 * @author Julien Deniau <julien@sitioweb.fr> 
 */
class ArmyController extends Controller
{
    /**
     * listAction
     *
     * @access public
     * @return void
     *
     * @Route("/group/{groupId}", requirements={"groupId" = "\d+"}, name="army_group_list")
     * @Route("/", name="army_list", defaults={"groupId" = null})
     * @Template()
     * @Secure(roles="IS_AUTHENTICATED_FULLY")
     */
    public function listAction($groupId)
    {
        if ($groupId > 0) {
            $group = $this->get('doctrine')->getManager()->getRepository('SitiowebArmyCreatorBundle:ArmyGroup')->find((int) $groupId);
            $deleteForm = $this->createDeleteForm($id);
        } else {
            $group = null;
            $deleteForm = null;
        }
        
        return array(
            'group' => $group,
            'deleteForm' => $deleteForm
        );
    }

    /**
     * detailAction
     *
     * @access public
     * @return void
     *
     * @Route("/{slug}", name="army_detail")
     * @Template()
     */
    public function detailAction($slug)
    {
        $army = $this->get('doctrine')->getManager()->getRepository('SitiowebArmyCreatorBundle:Army')->findOneBy(array(
            'slug' => $slug
        ));
        if ($army === null) {
            throw new NotFoundHttpException('Army not found');
        }
        
        
        return array();
    }

    /**
     * createDeleteForm
     *
     * @param int $id
     * @access private
     * @return void
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}

