<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Form;

use Doctrine\ORM\EntityRepository;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Breed;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UnitStuffMultiType extends AbstractType
{
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
            'entry_type' => UnitStuffType::class,
            'translation_domain' => 'forms',
        ));
    }

    public function getParent()
    {
        return CollectionType::class;
    }

    /**
     * getName
     *
     * @access public
     * @return void
     */
    public function getBlockPrefix()
    {
        return 'armycreator_unitstuffmulti';
    }
}
