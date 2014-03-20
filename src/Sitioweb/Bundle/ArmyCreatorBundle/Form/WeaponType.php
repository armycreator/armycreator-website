<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class WeaponType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('type', null, ['required' => false])
            ->add('range', null, ['required' => false])
            ->add('strenght', null, ['required' => false])
            ->add('armorPenetration', null, ['required' => false])
            ->add('rule', null, ['required' => false]);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sitioweb\Bundle\ArmyCreatorBundle\Entity\Weapon',
            'translation_domain' => 'forms'
        ));
    }

    public function getName()
    {
        return 'armycreator_weapontype';
    }
}
