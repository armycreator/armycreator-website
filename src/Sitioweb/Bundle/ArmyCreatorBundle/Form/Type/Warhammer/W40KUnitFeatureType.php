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
            ->add('cc', 'integer', ['required' => false, 'label' => 'unit_feature.w40k.cc'])
            ->add('ct', 'integer', ['required' => false, 'label' => 'unit_feature.w40k.ct'])
            ->add('fo', 'integer', ['required' => false, 'label' => 'unit_feature.w40k.fo'])
            ->add('en', 'integer', ['required' => false, 'label' => 'unit_feature.w40k.en'])
            ->add('pv', 'integer', ['required' => false, 'label' => 'unit_feature.w40k.pv'])
            ->add('in', 'integer', ['required' => false, 'label' => 'unit_feature.w40k.in'])
            ->add('at', 'text', ['required' => false, 'label' => 'unit_feature.w40k.at'])
            ->add('cd', 'integer', ['required' => false, 'label' => 'unit_feature.w40k.cd'])
            ->add('svg', 'text', ['required' => false, 'label' => 'unit_feature.w40k.svg'])
            ->add('vav', 'integer', ['required' => false, 'label' => 'unit_feature.w40k.vav'])
            ->add('vfl', 'integer', ['required' => false, 'label' => 'unit_feature.w40k.vfl'])
            ->add('var', 'integer', ['required' => false, 'label' => 'unit_feature.w40k.var'])
            ->add('pc', 'integer', ['required' => false, 'label' => 'unit_feature.w40k.pc'])
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sitioweb\Bundle\ArmyCreatorBundle\Model\Warhammer\W40KUnitFeature',
            'compound' => true,
            'translation_domain' => 'forms',
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
