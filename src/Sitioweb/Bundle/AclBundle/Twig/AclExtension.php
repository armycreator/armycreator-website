<?php

namespace Sitioweb\Bundle\AclBundle\Twig;

class AclExtension extends \Twig_Extension
{
    private $aclManager;

    public function __construct($oneupManager)
    {
        $this->aclManager = $oneupManager;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('ac_granted', [$this, 'acGranted']),
        );
    }

    public function acGranted($role, $object = null, $field = null)
    {
        return $this->aclManager->isGranted($role, $object, $field);
    }

    public function getName()
    {
        return 'armycreator_acl_extension';
    }
}
