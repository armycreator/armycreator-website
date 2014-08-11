<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

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
        $builder = $this->addBreedSpecifics($builder);
        $builder->add('submit', 'submit', ['attr' => ['class' => 'acButton acButtonBig']]);
    }

    /**
     * setDefaultOptions
     *
     * @param OptionsResolverInterface $resolver
     * @access public
     * @return void
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sitioweb\Bundle\ArmyCreatorBundle\Entity\UserUnitFeature',
            'translation_domain' => 'forms'
        ));
    }

    /**
     * getName
     *
     * @access public
     * @return string
     */
    public function getName()
    {
        return 'ac_userunitfeature';
    }
}
