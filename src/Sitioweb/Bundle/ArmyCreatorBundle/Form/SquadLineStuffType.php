<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SquadLineStuffType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('number', 'integer', array('attr' => array('size' => 4)));
        $builder->add(
            'asManyAsUnit',
            'checkbox',
            array(
                'required' => false,
                'label' => 'As many as unit',
                'attr' => array('title' => 'As many as unit')
            )
        );
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sitioweb\Bundle\ArmyCreatorBundle\Entity\SquadLineStuff'
        ));
    }

    public function getName()
    {
        return 'sitioweb_bundle_armycreatorbundle_squadlinestufftype';
    }
}



