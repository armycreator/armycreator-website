<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SquadType extends AbstractType
{
    private $unitList;

    public function setUnitList($unitList)
    {
        $this->unitList = $unitList;
        return $this;
    }

    public function __construct($unitList)
    {
        $this->setUnitList($unitList);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        ladybug_dump($this->unitList);
        
        foreach ($this->unitList as $unit) {
            $builder->add('squadLineList', 'collection', array('type' => new SquadLineType()));
        }
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        /*
        $resolver->setDefaults(array(
            'data_class' => 'Sitioweb\Bundle\ArmyCreatorBundle\Entity\Squad'
        ));
        */
    }

    public function getName()
    {
        return 'sitioweb_bundle_armycreatorbundle_squadtype';
    }
}

