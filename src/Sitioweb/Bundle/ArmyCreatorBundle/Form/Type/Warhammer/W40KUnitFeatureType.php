<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Form\Type\Warhammer;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Sitioweb\Bundle\ArmyCreatorBundle\Form\Type\RangeStrength;

class W40KUnitFeatureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cc', IntegerType::class, ['required' => false, 'label' => 'unit_feature.w40k.cc'])
            ->add('ct', IntegerType::class, ['required' => false, 'label' => 'unit_feature.w40k.ct'])
            ->add('fo', IntegerType::class, ['required' => false, 'label' => 'unit_feature.w40k.fo'])
            ->add('en', IntegerType::class, ['required' => false, 'label' => 'unit_feature.w40k.en'])
            ->add('pv', IntegerType::class, ['required' => false, 'label' => 'unit_feature.w40k.pv'])
            ->add('in', IntegerType::class, ['required' => false, 'label' => 'unit_feature.w40k.in'])
            ->add('at', TextType::class, ['required' => false, 'label' => 'unit_feature.w40k.at'])
            ->add('cd', IntegerType::class, ['required' => false, 'label' => 'unit_feature.w40k.cd'])
            ->add('svg', TextType::class, ['required' => false, 'label' => 'unit_feature.w40k.svg'])
            ->add('vav', IntegerType::class, ['required' => false, 'label' => 'unit_feature.w40k.vav'])
            ->add('vfl', IntegerType::class, ['required' => false, 'label' => 'unit_feature.w40k.vfl'])
            ->add('var', IntegerType::class, ['required' => false, 'label' => 'unit_feature.w40k.var'])
            ->add('pc', IntegerType::class, ['required' => false, 'label' => 'unit_feature.w40k.pc'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sitioweb\Bundle\ArmyCreatorBundle\Model\Warhammer\W40KUnitFeature',
            'compound' => true,
            'translation_domain' => 'forms',
        ));
    }

    public function getParent()
    {
        return TextType::class;
    }

    public function getBlockPrefix()
    {
        return 'ac_w40k_unitfeature';
    }
}
