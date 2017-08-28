<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserInformation extends AbstractType
{

    /**
     * buildForm
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     * @access public
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('address', TextType::class, ['required' => false])
            ->add('canMove', CheckboxType::class, ['required' => false])
            ->add('nbHost', TextType::class, ['required' => false])
            ->add('availability', TextType::class, ['required' => false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'translation_domain' => 'forms',
            'compound' => true,
        ));
    }

    public function getParent()
    {
        return TextType::class;
    }

    public function getBlockPrefix()
    {
        return 'ac_user_info';
    }
}



