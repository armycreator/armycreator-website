<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CollectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'userHasUnitList',
                'collection',
                array(
                    'type' => new UserHasUnitType()
                )
            )
            ->add('submit', 'submit', ['attr' => ['class' => 'acButton acButtonBig right']]);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'translation_domain' => 'forms',
            'cascade_validation' => true
        ));
    }

    public function getName()
    {
        return 'collectiontype';
    }
}

