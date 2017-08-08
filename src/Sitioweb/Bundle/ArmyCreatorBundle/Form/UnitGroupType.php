<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Form;

use Doctrine\ORM\EntityRepository;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Breed;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UnitGroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $breed = $options['breed'];

        $builder->add('unitType', null, array(
            'required' => true,
            'choice_label' => 'name',
            'query_builder' => function(EntityRepository $er) use ($breed) {
                return $er->createQueryBuilder('t')
                        ->add('where', 't.breed = :breed')
                        ->setParameter('breed', $breed);
            }
        ));

        $builder->add('name', null, ['attr' => ['autofocus' => 'autofocus']]);
        $builder->add('points', null, ['label' => 'Supplementary points']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('breed');
        $resolver->setAllowedTypes('breed', Breed::class);

        $resolver->setDefaults(array(
            'data_class' => 'Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitGroup',
            'translation_domain' => 'forms'
        ));
    }

    public function getBlockPrefix()
    {
        return 'unitgrouptype';
    }
}
