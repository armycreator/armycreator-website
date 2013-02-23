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
            ->add('status')
            ->add('name')
            ->add('description')
            ->add('wantedPoints', null, array('required' => false))
            ->add('isShared', null, array('required' => false))
            ->add('breed', null, array(
                'required' => true,
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('b')
                            ->add('orderBy', 'b.name ASC');
                }
            ))
            ->add('armyGroup', null, array(
                'property' => 'name',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('a')
                            ->add('where', 'a.user = :user')
                            ->setParameter('user', $this->user);
                }
            ));

        ;
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

