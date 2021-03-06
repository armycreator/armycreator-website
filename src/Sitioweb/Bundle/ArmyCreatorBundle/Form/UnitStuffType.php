<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Form;

use Doctrine\ORM\EntityRepository;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Breed;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;

class UnitStuffType extends AbstractType
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
            ->add(
                'visible',
                CheckboxType::class,
                [ 'required' => false, ]
            )
            ->add('points')
            ->add('auto', null, ['required' => false])
        ;
    }

    /**
     * configureOptions
     *
     * @param OptionsResolver $resolver
     * @access public
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitStuff',
            'translation_domain' => 'forms'
        ));
    }

    /**
     * getName
     *
     * @access public
     * @return void
     */
    public function getBlockPrefix()
    {
        return 'armycreator_unitstufftype';
    }
}
