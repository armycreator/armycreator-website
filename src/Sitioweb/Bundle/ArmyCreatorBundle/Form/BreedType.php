<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Game;

class BreedType extends AbstractType
{
    /**
     * game
     *
     * @var Game
     * @access private
     */
    private $game;

    /**
     * __construct
     *
     * @param Game $game
     * @access public
     * @return void
     */
    public function __construct(Game $game)
    {
        $this->game = $game;
    }

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
                                ->setParameter('game', $this->game);
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
                                ->setParameter('game', $this->game);
                    }
                ]
            )
            ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sitioweb\Bundle\ArmyCreatorBundle\Entity\Breed',
            'translation_domain' => 'forms'
        ));
    }

    public function getName()
    {
        return 'ac_breedtype';
    }
}
