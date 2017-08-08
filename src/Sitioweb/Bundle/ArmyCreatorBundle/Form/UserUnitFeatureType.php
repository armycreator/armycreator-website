<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Form;

use Doctrine\ORM\EntityRepository;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Breed;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserUnitFeatureType extends AbstractUnitType
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
        $builder = $this->addBreedSpecifics($builder, $options['breed']);
        $builder->add('submit', SubmitType::class, ['attr' => ['class' => 'acButton acButtonBig']]);
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
        $resolver->setRequired('breed');
        $resolver->setAllowedTypes('breed', Breed::class);

        $resolver->setDefaults(array(
            'data_class' => 'Sitioweb\Bundle\ArmyCreatorBundle\Entity\UserUnitFeature',
            'translation_domain' => 'forms'
        ));
    }

    /**
     * getBlockPrefix
     *
     * @access public
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'ac_userunitfeature';
    }
}
