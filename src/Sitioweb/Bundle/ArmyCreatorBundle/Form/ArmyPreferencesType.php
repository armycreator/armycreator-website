<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Sitioweb\Bundle\ArmyCreatorBundle\Entity\User;

class ArmyPreferencesType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'showDefaultStuff',
                null,
                array('required' => false)
            )
            ->add(
                'showUnitPoints',
                null,
                array('required' => false)
            )
            ->add(
                'showStuffPoints',
                null,
                array('required' => false)
            )
            ->add(
                'showStuffDescription',
                null,
                array('required' => false)
            )
            //->add('showNbIfAlone')
            //->add('showUnitCarac')
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
        return 'ac_army';
    }
}


