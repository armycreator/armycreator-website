<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Sitioweb\Bundle\ArmyCreatorBundle\Entity\User;

class ArmyType extends AbstractType
{
    private $user;

    public function __construct(User $user)
    {
        $this->setUser($user);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'breed',
                'armybreed',
                [
                    'required' => true,
                    'preferred_choices' => array_slice($this->user->getPreferedBreedList(), 0, 10)
                ]
            )
            ->add('name', null, array('required' => false))
            ->add('description',null, ['attr' => ['rows' => 3, 'cols' => 50]])
            ->add('wantedPoints', null, array('required' => false))
            ->add(
                'armyGroup',
                null,
                array(
                    'property' => 'name',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('a')
                                ->add('where', 'a.user = :user')
                                ->setParameter('user', $this->user);
                    }
                )
            )
            ->add('isShared', null, array('required' => false))
            ->add(
                'status',
                ChoiceType::class,
                array(
                    'choices' => array('draft' => 'draft', 'finish' => 'finish'),
                    'required' => true,
                    'expanded' => true,
                )
            );
    }

    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sitioweb\Bundle\ArmyCreatorBundle\Entity\Army',
            'translation_domain' => 'forms'
        ));
    }

    public function getBlockPrefix()
    {
        return 'ac_armytype';
    }
}

