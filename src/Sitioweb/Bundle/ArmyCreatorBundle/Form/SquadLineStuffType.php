<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SquadLineStuffType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'number',
            IntegerType::class,
            array(
                'attr' => array('size' => 4, 'title' => 'Number')
            )
        );
        $builder->add(
            'asManyAsUnit',
            CheckboxType::class,
            array(
                'required' => false,
                'label' => 'As many as unit',
                'attr' => array('title' => 'As many as unit')
            )
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sitioweb\Bundle\ArmyCreatorBundle\Entity\SquadLineStuff',
            'translation_domain' => 'forms'
        ));
    }

    public function getBlockPrefix()
    {
        return 'ac_squadlinestufftype';
    }
}
