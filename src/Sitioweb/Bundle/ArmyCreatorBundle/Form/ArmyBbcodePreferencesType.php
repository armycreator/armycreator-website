<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Form;

use Doctrine\ORM\EntityRepository;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArmyBbcodePreferencesType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'showDefaultStuff',
                null,
                array(
                    'required' => false
                )
            )
            //->add('showStuffDescription')
            ->add(
                'showUnitPoints',
                null,
                array('required' => false)
            )
            //->add('showStuffPoints')
            ->add(
                'separator',
                ChoiceType::class,
                array(
                    'choices' => [
                        'ac_armybbcode.form.carriage_return' => '[*]',
                        'ac_armybbcode.form.slash' => '/',
                        'ac_armybbcode.form.comma' => ',',
                    ],
                )
            )
            ->add(
                'colorSquadType',
                TextType::class,
                [
                    'attr' => [ 'class' => 'color']
                ]
            )
            ->add('colorSquad', TextType::class, [ 'attr' => [ 'class' => 'color'] ])
            ->add('colorSquadDetail', TextType::class, [ 'attr' => [ 'class' => 'color'] ])
            //->add('showNbIfAlone')
            //->add('showUnitCarac')
            //->add('showPersonnalName')
            //->add('user')
            //->add('breed')
        ;
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sitioweb\Bundle\ArmyCreatorBundle\Entity\UserPreference',
            'translation_domain' => 'forms'
        ));
    }

    public function getBlockPrefix()
    {
        return 'ac_armybbcode';
    }
}
