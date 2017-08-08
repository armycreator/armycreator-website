<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Form;

use Doctrine\ORM\EntityRepository;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\User;
use Sitioweb\Bundle\ArmyCreatorBundle\Form\Type\ArmyBreedType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArmyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $options['user'];

        $builder
            ->add(
                'breed',
                ArmyBreedType::class,
                [
                    'required' => true,
                    'preferred_choices' => array_slice($user->getPreferedBreedList(), 0, 10)
                ]
            )
            ->add('name', null, array('required' => false))
            ->add('description',null, ['attr' => ['rows' => 3, 'cols' => 50]])
            ->add('wantedPoints', null, array('required' => false))
            ->add(
                'armyGroup',
                null,
                array(
                    'choice_label' => 'name',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('a')
                                ->add('where', 'a.user = :user')
                                ->setParameter('user', $user);
                    }
                )
            )
            ->add('isShared', null, array('required' => false))
            ->add(
                'status',
                ChoiceType::class,
                array(
                    'choices' => array('draft' => 'draft', 'finish' => 'finish'),
                    'choices_as_values' => true,
                    'required' => true,
                    'expanded' => true,
                )
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired(['user']);

        $resolver->setDefaults(array(
            'data_class' => 'Sitioweb\Bundle\ArmyCreatorBundle\Entity\Army',
            'translation_domain' => 'forms',
        ));
    }

    public function getBlockPrefix()
    {
        return 'ac_armytype';
    }
}

