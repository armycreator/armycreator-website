<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UnitType extends AbstractUnitType
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
                'unitType',
                null,
                array(
                    'property' => 'name',
                    'required' => true,
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('t')
                                ->add('where', 't.breed = :breed')
                                ->setParameter('breed', $this->breed);
                    }
                )
            )
            ->add('name')
            ->add('points')
            /*
            ->add('unitHasUnitGroupList', 'collection', array('type' => new UnitHasUnitGroupType()))
            */
            ->add(
                'doNotCreateUnitGroup',
                'checkbox',
                array(
                    'mapped' => false,
                    'required' => false,
                )
            );

        $builder = $this->addBreedSpecifics($builder);
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
            'data_class' => 'Sitioweb\Bundle\ArmyCreatorBundle\Entity\Unit',
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
        return 'unittype';
    }
}
