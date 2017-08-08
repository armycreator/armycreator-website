<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CollectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'userHasUnitList',
                CollectionType::class,
                array(
                    'type' => new UserHasUnitType()
                )
            )
            ->add('submit', SubmitType::class, ['attr' => ['class' => 'acButton acButtonBig right']]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'translation_domain' => 'forms',
            'cascade_validation' => true
        ));
    }

    public function getBlockPrefix()
    {
        return 'collectiontype';
    }
}

