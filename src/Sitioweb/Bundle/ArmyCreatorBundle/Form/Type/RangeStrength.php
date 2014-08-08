<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RangeStrength extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('range', 'text', ['required' => false])
            ->add('strength', 'integer', ['required' => false])
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sitioweb\Bundle\ArmyCreatorBundle\Model\RangeStrength',
            'compound' => true
        ));
    }

    public function getParent()
    {
        return 'text';
    }

    public function getName()
    {
        return 'ac_range_strength';
    }
}
