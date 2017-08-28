<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Breed;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StuffType extends AbstractType
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
     * configureOptions
     *
     * @param OptionsResolver $resolver
     * @access public
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'class' => 'Sitioweb\Bundle\ArmyCreatorBundle\Entity\Stuff',
            'choice_label' => 'name',
            'query_builder' => function(EntityRepository $er) {
                $qb = $er->createQueryBuilder('s');
                $qb
                    ->where($qb->expr()->orX(
                        $qb->expr()->eq('s.breed', ':breed'),
                        $qb->expr()->eq('s.game', ':game')
                    ))
                    ->add('orderBy', 's.name ASC')
                    ->setParameter('breed', $this->breed)
                    ->setParameter('game', $this->breed->getGame());

                return $qb;
            }
        ]);
    }

    /**
     * getParent
     *
     * @access public
     * @return string
     */
    public function getParent()
    {
        return EntityType::class;
    }

    /**
     * getName
     *
     * @access public
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'ac_stuff';
    }
}
