<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Form\Type\Warhammer;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WeaponDescriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('type', null, ['required' => false])
            ->add('range', null, ['required' => false])
            ->add('strenght', null, ['required' => false])
            ->add('armorPenetration', null, ['required' => false])
            ->add('rule', TextareaType::class, ['required' => false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sitioweb\Bundle\ArmyCreatorBundle\Model\Warhammer\Weapon',
            'compound' => true
        ));
    }

    public function getParent()
    {
        return TextType::class;
    }

    public function getBlockPrefix()
    {
        return 'ac_warhammer_weapon';
    }
}
