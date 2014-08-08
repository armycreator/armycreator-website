<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Form\Type\Warhammer;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class WeaponDescriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('type', null, ['required' => false])
            ->add('range', null, ['required' => false])
            ->add('strenght', null, ['required' => false])
            ->add('armorPenetration', null, ['required' => false])
            ->add('rule', 'textarea', ['required' => false])
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sitioweb\Bundle\ArmyCreatorBundle\Model\Warhammer\Weapon',
            'compound' => true
        ));
    }

    public function getParent()
    {
        return 'text';
    }

    public function getName()
    {
        return 'ac_warhammer_weapon';
    }
}
