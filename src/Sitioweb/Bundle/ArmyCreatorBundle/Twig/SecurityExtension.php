<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Twig;

use Symfony\Bridge\Twig\Extension\SecurityExtension as SymfonySecurityExtension;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class SecurityExtension
 * @author Julien Deniau <julien.deniau@gmail.com>
 */
class SecurityExtension extends \Twig_Extension
{
    /**
     * @param SymfonySecurityExtension $securityExtension
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(SymfonySecurityExtension $securityExtension, TokenStorageInterface $tokenStorage)
    {
        $this->securityExtension = $securityExtension;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * getFunctions
     *
     * @access public
     * @return array
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction(
                'ac_is_granted',
                array($this, 'acIsGranted')
            )
        );
    }

    public function acIsGranted($role, $object = null, $field = null)
    {
        if (!$this->tokenStorage->getToken()) {
            return false;
        }

        return $this->securityExtension->isGranted($role, $object, $field);
    }
}
