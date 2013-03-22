<?php

namespace Sitioweb\Bundle\DiceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ShotFiredType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('unitNumber', 'integer')
            ->add('shotsByUnit', 'integer')
            ->add('weaponSkill', 'integer')
            ->add('weaponStrength', 'integer')
            ->add('toughness', 'integer')
            ->add('save', 'integer')
            ->add('secondSave', 'integer');
    }


    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sitioweb\Bundle\DiceBundle\Model\ShotFired',
             'translation_domain' => 'forms'
        ));
    }

    public function getName()
    {
        return 'ac_dice_shot';
    }
}
