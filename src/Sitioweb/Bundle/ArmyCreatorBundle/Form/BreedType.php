<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Game;

class BreedType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('available')
            ->add('image')
            ->add(
                'newVersion',
                null,
                [
                    'empty_value' => 'Choose a value',
                    'required' => false,
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('a')
                                ->add('where', 'a.game = :game')
                                ->setParameter('game', $options['game']);
                    }
                ]
            )
            //->add('game')
            ->add(
                'breedGroup',
                null,
                [
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('a')
                                ->add('where', 'a.game = :game')
                                ->setParameter('game', $options['game']);
                    }
                ]
            )
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('game');
        $resolver->setAllowedTypes('game', Game::class);

        $resolver->setDefaults(array(
            'data_class' => 'Sitioweb\Bundle\ArmyCreatorBundle\Entity\Breed',
            'translation_domain' => 'forms'
        ));
    }

    public function getBlockPrefix()
    {
        return 'ac_breedtype';
    }
}
