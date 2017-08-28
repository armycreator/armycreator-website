<?php

namespace Sitioweb\Bundle\DiceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ShotFiredType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('unitNumber', IntegerType::class)
            ->add('shotsByUnit', IntegerType::class)
            ->add('ballisticSkill', IntegerType::class)
            ->add('weaponStrength', IntegerType::class)
            ->add('toughness', IntegerType::class)
            ->add('save', IntegerType::class)
            ->add('secondSave', IntegerType::class);
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sitioweb\Bundle\DiceBundle\Model\ShotFired',
        ));
    }

    public function getBlockPrefix()
    {
        return 'ac_dice_shot';
    }
}
