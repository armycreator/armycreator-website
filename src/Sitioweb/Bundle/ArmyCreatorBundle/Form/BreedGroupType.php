<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BreedGroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('game')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sitioweb\Bundle\ArmyCreatorBundle\Entity\BreedGroup',
            'translation_domain' => 'forms'
        ));
    }

    public function getBlockPrefix()
    {
        return 'ac_breedgrouptype';
    }
}
