<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Form;

use Doctrine\ORM\EntityRepository;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Breed;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Valid;

class UnitHasUnitGroupType extends AbstractType
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
        $breed = $options['breed'];

        $builder->add(
                    'unit',
                    null,
                    array(
                        'attr' => ['autofocus' => 'autofocus'],
                        'required' => true,
                        'choice_label' => 'nameAndPoints',
                        'query_builder' => function(EntityRepository $er) {
                            return $er->createQueryBuilder('u')
                                    ->add('where', 'u.breed = :breed')
                                    ->add('orderBy', 'u.name ASC')
                                    ->setParameter('breed', $breed);
                        }
                    )
                )
                ->add(
                    'group',
                    null,
                    array(
                        'required' => true,
                        'choice_label' => 'name',
                        'query_builder' => function(EntityRepository $er) {
                            return $er->createQueryBuilder('u')
                                    ->add('where', 'u.breed = :breed')
                                    ->add('orderBy', 'u.name ASC')
                                    ->setParameter('breed', $breed);
                        }
                    )
                )
                ->add('unitNumber')
                ->add('canChooseNumber', null, array('required' => false));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('breed');
        $resolver->setAllowedTypes('breed', Breed::class);

        $resolver->setDefaults(array(
            'data_class' => 'Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitHasUnitGroup',
            'translation_domain' => 'forms',
        ));
    }

    public function getBlockPrefix()
    {
        return 'ac_unithasunitgrouptype';
    }
}

