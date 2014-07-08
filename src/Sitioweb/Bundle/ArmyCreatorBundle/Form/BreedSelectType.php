<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BreedSelectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'breed',
                'armybreed',
                [
                    'required' => true,
                ]
            )
            ->add('submit', 'submit', ['attr' => ['class' => 'acButton']])
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
            'translation_domain' => 'forms'
        ));
    }

    public function getName()
    {
        return 'ac_breed_select';
    }
}
