<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Breed;

class SquadType extends AbstractType
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
        $builder->add('unitType', null, array(
            'required' => true,
            'property' => 'name',
            'query_builder' => function(EntityRepository $er) {
                return $er->createQueryBuilder('t')
                        ->add('where', 't.breed = :breed')
                        ->setParameter('breed', $this->breed);
            }
        ));

        $builder->add('name', null, array('attr' => array('size' => 50)));

        $builder->add('squadLineList', 'collection', array('type' => new SquadLineType()));
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
            'data_class' => 'Sitioweb\Bundle\ArmyCreatorBundle\Entity\Squad',
            'translation_domain' => 'forms',
            'cascade_validation' => true,
            'csrf_protection' => false,
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
        return 'ac_squadtype';
    }
}
