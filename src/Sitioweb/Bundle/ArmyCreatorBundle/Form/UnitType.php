<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
            ->add('name', null, ['attr' => ['autofocus' => 'autofocus']])
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
            )
        ;

        $builder = $this->addBreedSpecifics($builder);

        if ($options['data']->getId()) {
             $builder->add('edit', 'submit');
        } else {
             $builder->add('create', 'submit')
                 ->add('createAndAdd', 'submit');
        }
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
