<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Form\Type\Warhammer;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Sitioweb\Bundle\ArmyCreatorBundle\Form\Type\RangeStrength;

class W40KUnitFeatureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cc', 'integer', ['required' => false])
            ->add('ct', 'integer', ['required' => false])
            ->add('fo', 'integer', ['required' => false])
            ->add('en', 'integer', ['required' => false])
            ->add('pv', 'integer', ['required' => false])
            ->add('in', 'integer', ['required' => false])
            ->add('at', 'integer', ['required' => false])
            ->add('cd', 'integer', ['required' => false])
            ->add('svg', 'text', ['required' => false])
            ->add('vav', 'integer', ['required' => false])
            ->add('vfl', 'integer', ['required' => false])
            ->add('var', 'integer', ['required' => false])
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sitioweb\Bundle\ArmyCreatorBundle\Model\Warhammer\W40KUnitFeature',
            'compound' => true,
        ));
    }

    public function getParent()
    {
        return 'text';
    }

    public function getName()
    {
        return 'ac_w40k_unitfeature';
    }
}
