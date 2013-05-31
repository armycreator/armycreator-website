<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Breed;

class UnitGroupType extends AbstractType
{
    /**
     * breed
     * 
     * @var Breed
     * @access private
     */
    private $breed;

    /**
     * __construct
     *
     * @param Breed $breed
     * @access private
     * @return void
     */
    public function __construct(Breed $breed)
    {
        $this->breed = $breed;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('unitType', null, array(
            'required' => true,
            'property' => 'name',
            'query_builder' => function(EntityRepository $er) {
                return $er->createQueryBuilder('t')
                        ->add('where', 't.breed = :breed')
                        ->setParameter('breed', $this->breed);
            }
        ));

        $builder->add('name');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitGroup'
        ));
    }

    public function getName()
    {
        return 'unitgrouptype';
    }
}
