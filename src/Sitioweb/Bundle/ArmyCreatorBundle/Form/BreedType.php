<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BreedType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('available')
            ->add('newVersion', null, array('empty_value' => 'Choose a value', 'required' => false))
            ->add('game')
            ->add('breedGroup')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sitioweb\Bundle\ArmyCreatorBundle\Entity\Breed',
            'translation_domain' => 'forms'
        ));
    }

    public function getName()
    {
        return 'ac_breedtype';
    }
}
