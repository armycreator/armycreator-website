<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SquadType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', null, array('attr' => array('size' => 50)));
        
        $builder->add('squadLineList', 'collection', array('type' => new SquadLineType()));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sitioweb\Bundle\ArmyCreatorBundle\Entity\Squad',
            'cascade_validation' => true
        ));
    }

    public function getName()
    {
        return 'sitioweb_bundle_armycreatorbundle_squadtype';
    }
}

