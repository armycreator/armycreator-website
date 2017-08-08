<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Form\Type\FArm;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Sitioweb\Bundle\ArmyCreatorBundle\Form\Type\RangeStrength;

class EquipementDescriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(0, new RangeStrength)
            ->add(1, new RangeStrength)
            ->add(2, new RangeStrength)
            ->add(3, new RangeStrength)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sitioweb\Bundle\ArmyCreatorBundle\Model\PrintableArrayObject',
            'compound' => true,
        ));
    }

    public function getParent()
    {
        return TextType::class;
    }

    public function getBlockPrefix()
    {
        return 'ac_farm_weapon';
    }
}
