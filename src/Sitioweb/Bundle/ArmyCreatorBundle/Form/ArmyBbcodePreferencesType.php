<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;

use Sitioweb\Bundle\ArmyCreatorBundle\Entity\User;

class ArmyBbcodePreferencesType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'showDefaultStuff',
                null,
                array('required' => false)
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
                'choice',
                array(
                    'choice_list' => new ChoiceList(
                        array('[*]', ' / ', ', '),
                        array(
                            'ac_armybbcode.form.carriage_return',
                            'ac_armybbcode.form.slash',
                            'ac_armybbcode.form.comma'
                        )
                    ),
                    'expanded' => true
                )
            )
            ->add('colorSquadType')
            ->add('colorSquad')
            ->add('colorSquadDetail')
            //->add('showNbIfAlone')
            //->add('showUnitCarac')
            //->add('showPersonnalName')
            //->add('user')
            //->add('breed')
        ;
    }


    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sitioweb\Bundle\ArmyCreatorBundle\Entity\UserPreference',
            'translation_domain' => 'forms'
        ));
    }

    public function getName()
    {
        return 'ac_armybbcode';
    }
}
