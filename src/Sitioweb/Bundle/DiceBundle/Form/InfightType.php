<?php

namespace Sitioweb\Bundle\DiceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InfightType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('unitNumber', IntegerType::class)
            ->add('hitByUnit', IntegerType::class)
            ->add('supplementaryHit', CheckboxType::class, array('required' => false))
            ->add('weaponSkill', IntegerType::class)
            ->add('opponentWeaponSkill', IntegerType::class)
            ->add('strength', IntegerType::class)
            ->add('toughness', IntegerType::class)
            ->add('save', IntegerType::class)
            ->add('secondSave', IntegerType::class);
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sitioweb\Bundle\DiceBundle\Model\Infight',
        ));
    }

    public function getBlockPrefix()
    {
        return 'ac_dice_shot';
    }
}

