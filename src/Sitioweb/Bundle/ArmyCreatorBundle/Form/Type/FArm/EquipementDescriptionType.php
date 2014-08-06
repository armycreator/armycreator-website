<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Form\Type\FArm;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

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

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'compound' => true,
        ));
    }

    public function getParent()
    {
        return 'text';
    }

    public function getName()
    {
        return 'ac_farm_equipement';
    }
}

