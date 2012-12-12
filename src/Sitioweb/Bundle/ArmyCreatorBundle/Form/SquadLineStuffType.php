<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SquadLineStuffType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('number', 'integer');
        $builder->add('auto', 'checkbox', array('label' => 'As many as unit'));
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



