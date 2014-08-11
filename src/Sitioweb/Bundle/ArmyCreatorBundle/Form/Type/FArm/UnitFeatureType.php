<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Form\Type\FArm;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Sitioweb\Bundle\ArmyCreatorBundle\Form\Type\RangeStrength;

class UnitFeatureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dr', 'integer')
            ->add('cr', 'integer')
            ->add('mv', 'integer')
            ->add('hp', 'integer')
            ->add('cp', 'integer')
            ->add('ap', 'integer')
            ->add('pd', 'integer')
            ->add('mn', 'integer')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sitioweb\Bundle\ArmyCreatorBundle\Model\FArm\UnitFeature',
            'compound' => true,
        ));
    }

    public function getParent()
    {
        return 'text';
    }

    public function getName()
    {
        return 'ac_farm_unitfeature';
    }
}
