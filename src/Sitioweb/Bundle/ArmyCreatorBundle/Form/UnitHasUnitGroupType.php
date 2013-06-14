<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Breed;

class UnitHasUnitGroupType extends AbstractType
{
    /**
     * breed
     * 
     * @var Breed
     * @access private
     */
    private $breed;

    public function __construct(Breed $breed)
    {
        $this->breed = $breed;
    }

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
        $builder->add(
                    'unit',
                    null, 
                    array(
                        'required' => true,
                        'property' => 'name',
                        'query_builder' => function(EntityRepository $er) {
                            return $er->createQueryBuilder('u')
                                    ->add('where', 'u.breed = :breed')
                                    ->add('orderBy', 'u.name ASC')
                                    ->setParameter('breed', $this->breed);
                        }
                    )
                )
                ->add(
                    'group',
                    null, 
                    array(
                        'required' => true,
                        'property' => 'name',
                        'query_builder' => function(EntityRepository $er) {
                            return $er->createQueryBuilder('u')
                                    ->add('where', 'u.breed = :breed')
                                    ->add('orderBy', 'u.name ASC')
                                    ->setParameter('breed', $this->breed);
                        }
                    )
                )
                ->add('unitNumber')
                ->add('canChooseNumber', null, array('required' => false));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitHasUnitGroup',
            'translation_domain' => 'forms',
            'cascade_validation' => true
        ));
    }

    public function getName()
    {
        return 'ac_unithasunitgrouptype';
    }
}

