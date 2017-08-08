<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Form\Type\FArm;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Sitioweb\Bundle\ArmyCreatorBundle\Form\Type\RangeStrength;

class UnitFeatureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dr', IntegerType::class)
            ->add('cr', IntegerType::class)
            ->add('mv', IntegerType::class)
            ->add('hp', IntegerType::class)
            ->add('cp', IntegerType::class)
            ->add('ap', IntegerType::class)
            ->add('pd', IntegerType::class)
            ->add('mn', IntegerType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sitioweb\Bundle\ArmyCreatorBundle\Model\FArm\UnitFeature',
            'compound' => true,
        ));
    }

    public function getParent()
    {
        return TextType::class;
    }

    public function getBlockPrefix()
    {
        return 'ac_farm_unitfeature';
    }
}
