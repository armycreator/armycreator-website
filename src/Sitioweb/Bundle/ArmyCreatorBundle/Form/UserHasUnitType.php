<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Form;

use Sitioweb\Bundle\ArmyCreatorBundle\Entity\UserHasUnit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserHasUnitType extends AbstractType
{

    /**
     * buildForm
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     * @access public
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'number',
            IntegerType::class,
            array('attr' => array('size' => 4, 'title' => 'Number'))
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sitioweb\Bundle\ArmyCreatorBundle\Entity\UserHasUnit',
            'translation_domain' => 'forms',
        ));
    }

    public function getBlockPrefix()
    {
        return 'ac_userhasunittype';
    }
}

