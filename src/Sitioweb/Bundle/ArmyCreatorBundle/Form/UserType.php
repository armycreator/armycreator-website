<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Form;

use Sitioweb\Bundle\ArmyCreatorBundle\Form\Type\UserInformation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Valid;

class UserType extends AbstractType
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
        $builder
            ->add('wantToPlay', null, ['required' => false])
            ->add('informations', UserInformation::class, [ 'constraints' => new Valid() ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sitioweb\Bundle\ArmyCreatorBundle\Entity\User',
            'translation_domain' => 'forms',
        ));
    }

    public function getBlockPrefix()
    {
        return 'ac_user';
    }
}
