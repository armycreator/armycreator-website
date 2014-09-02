<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Breed;

class UnitStuffType extends AbstractType
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
     * @access public
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
        $builder
            ->add('points')
            ->add('auto', null, ['required' => false])
            ->add('visible', null, ['required' => false])
            ->add(
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
                'stuff',
                new Type\StuffType($this->breed),
                array(
                    'required' => true,
                )
             );

        if ($options['data']->getId()) {
             $builder->add('edit', 'submit');
        } else {
             $builder->add('createAndAdd', 'submit')
                ->add('create', 'submit');
        }
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
            'data_class' => 'Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitStuff',
            'translation_domain' => 'forms'
        ));
    }

    /**
     * getName
     *
     * @access public
     * @return void
     */
    public function getName()
    {
        return 'armycreator_unitstufftype';
    }
}
