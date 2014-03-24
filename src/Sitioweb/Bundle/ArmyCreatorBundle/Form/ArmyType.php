<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

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
                null,
                array(
                    'required' => true,
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('b')
                                ->where('b.available = :available')
                                ->add('orderBy', 'b.name ASC')
                                ->setParameter('available', true);
                    }
                )
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
                'choice',
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

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sitioweb\Bundle\ArmyCreatorBundle\Entity\Army',
            'translation_domain' => 'forms'
        ));
    }

    public function getName()
    {
        return 'ac_armytype';
    }
}

