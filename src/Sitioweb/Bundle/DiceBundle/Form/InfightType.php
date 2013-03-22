<?php

namespace Sitioweb\Bundle\DiceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class InfightType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('unitNumber', 'integer')
            ->add('hitByUnit', 'integer')
            ->add('supplementaryHit', 'checkbox')
            ->add('weaponSkill', 'integer')
            ->add('opponentWeaponSkill', 'integer')
            ->add('strength', 'integer')
            ->add('toughness', 'integer')
            ->add('save', 'integer')
            ->add('secondSave', 'integer');
    }


    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sitioweb\Bundle\DiceBundle\Model\Infight',
             'translation_domain' => 'forms'
        ));
    }

    public function getName()
    {
        return 'ac_dice_shot';
    }
}

