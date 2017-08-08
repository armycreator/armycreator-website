<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Form;

use Sitioweb\Bundle\ArmyCreatorBundle\Entity\SquadLine;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Valid;

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
            array(
                'type' => SquadLineStuffType::class,
                'constraints' => new Valid(),
            )
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sitioweb\Bundle\ArmyCreatorBundle\Entity\SquadLine',
            'translation_domain' => 'forms',
        ));
    }

    public function getBlockPrefix()
    {
        return 'ac_squadlinetype';
    }
}
