<?php

namespace Sitioweb\Bundle\DiceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DiceType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('diceNumber', IntegerType::class)
            ->add('wantedScore', IntegerType::class)
        ;
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sitioweb\Bundle\DiceBundle\Model\DiceLaunch'
        ));
    }

    public function getBlockPrefix()
    {
        return 'ac_dice_launch';
    }
}
