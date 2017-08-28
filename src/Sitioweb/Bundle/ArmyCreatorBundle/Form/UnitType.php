<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Form;

use Doctrine\ORM\EntityRepository;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Breed;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
                    'choice_label' => 'name',
                    'required' => true,
                    'query_builder' => function(EntityRepository $er) use ($options) {
                        return $er->createQueryBuilder('t')
                                ->add('where', 't.breed = :breed')
                                ->setParameter('breed', $options['breed']);
                    }
                )
            )
            ->add('name', null, ['attr' => ['autofocus' => 'autofocus']])
            ->add('points')
            /*
            ->add('unitHasUnitGroupList', CollectionType::class, array('entry_type' => UnitHasUnitGroupType::class))
            */
            ->add(
                'doNotCreateUnitGroup',
                CheckboxType::class,
                array(
                    'mapped' => false,
                    'required' => false,
                )
            )
        ;

        $builder = $this->addBreedSpecifics($builder, $options['breed']);

        if ($options['data']->getId()) {
             $builder->add('edit', SubmitType::class);
        } else {
             $builder->add('create', SubmitType::class)
                 ->add('createAndAdd', SubmitType::class);
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
        $resolver->setRequired('breed');
        $resolver->setAllowedTypes('breed', Breed::class);

        $resolver->setDefaults(array(
            'data_class' => 'Sitioweb\Bundle\ArmyCreatorBundle\Entity\Unit',
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
        return 'unittype';
    }
}
