<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType as SymfonyCollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Valid;

class CollectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'userHasUnitList',
                SymfonyCollectionType::class,
                array(
                    'entry_type' => UserHasUnitType::class,
                    'constraints' => new Valid(),
                )
            )
            ->add('submit', SubmitType::class, ['attr' => ['class' => 'acButton acButtonBig right']]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'translation_domain' => 'forms',
        ));
    }

    public function getBlockPrefix()
    {
        return 'collectiontype';
    }
}

