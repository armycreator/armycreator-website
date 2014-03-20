<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EquipementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description', null, ['attr' => ['rows' => 5, 'cols' => 150]])
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sitioweb\Bundle\ArmyCreatorBundle\Entity\Equipement',
            'translation_domain' => 'forms'
        ));
    }

    public function getName()
    {
        return 'armycreator_equipementtype';
    }
}
