<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UnitTypeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, ['attr' => ['autofocus' => 'autofocus']])
            ->add('color', TextType::class, [ 'attr' => [ 'class' => 'color'] ])
            ->add('position')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitType',
            'translation_domain' => 'forms'
        ));
    }

    public function getBlockPrefix()
    {
        return 'sitioweb_bundle_armycreatorbundle_unittypetype';
    }
}
