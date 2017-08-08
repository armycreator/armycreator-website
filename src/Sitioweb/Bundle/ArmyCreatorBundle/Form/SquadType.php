<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Form;

use Doctrine\ORM\EntityRepository;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Breed;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Valid;

class SquadType extends AbstractType
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
        $builder->add('unitType', null, array(
            'required' => true,
            'choice_label' => 'name',
            'query_builder' => function(EntityRepository $er) use ($options) {
                return $er->createQueryBuilder('t')
                        ->add('where', 't.breed = :breed')
                        ->setParameter('breed', $options['breed']);
            }
        ));

        $builder->add('name', null, array('attr' => array('size' => 50)));

        $builder->add(
            'squadLineList',
            CollectionType::class,
            [
                'entry_type' => SquadLineType::class,
                'constraints' => new Valid(),
            ]
        );
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
            'data_class' => 'Sitioweb\Bundle\ArmyCreatorBundle\Entity\Squad',
            'translation_domain' => 'forms',
            'csrf_protection' => false,
        ));
    }

    /**
     * getName
     *
     * @access public
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'ac_squadtype';
    }
}
