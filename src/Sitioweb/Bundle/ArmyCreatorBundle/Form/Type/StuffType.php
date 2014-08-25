<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class StuffType extends AbstractType
{
    /**
     * setDefaultOptions
     *
     * @param OptionsResolverInterface $resolver
     * @access public
     * @return void
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'class' => 'Sitioweb\Bundle\ArmyCreatorBundle\Entity\Stuff',
        ]);
    }

    /**
     * getParent
     *
     * @access public
     * @return string
     */
    public function getParent()
    {
        return 'entity';
    }

    /**
     * getName
     *
     * @access public
     * @return string
     */
    public function getName()
    {
        return 'ac_stuff';
    }
}
