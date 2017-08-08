<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Sitioweb\Bundle\ArmyCreatorBundle\Entity\SquadLine;

class SquadLineType extends AbstractType
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

        $builder->add(
            'orderSquadLineStuffList',
            CollectionType::class,
            array('type' => new SquadLineStuffType())
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sitioweb\Bundle\ArmyCreatorBundle\Entity\SquadLine',
            'translation_domain' => 'forms',
            'cascade_validation' => true
        ));
    }

    public function getBlockPrefix()
    {
        return 'ac_squadlinetype';
    }
}
