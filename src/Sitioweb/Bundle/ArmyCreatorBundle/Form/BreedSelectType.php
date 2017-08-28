<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Form;

use Sitioweb\Bundle\ArmyCreatorBundle\Form\Type\ArmyBreedType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BreedSelectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'breed',
                ArmyBreedType::class,
                [
                    'required' => true,
                ]
            )
            ->add('submit', SubmitType::class, ['attr' => ['class' => 'acButton']])
        ;
    }

    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'translation_domain' => 'forms'
        ));
    }

    public function getBlockPrefix()
    {
        return 'ac_breed_select';
    }
}
