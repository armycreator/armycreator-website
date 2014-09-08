<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Breed;

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
     * setDefaultOptions
     *
     * @param OptionsResolverInterface $resolver
     * @access public
     * @return void
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'class' => 'Sitioweb\Bundle\ArmyCreatorBundle\Entity\Stuff',
            'property' => 'name',
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
        return 'entity';
    }

    /**
     * getName
     *
     * @access public
     * @return string
     */
    public function getName()
    {
        return 'ac_stuff';
    }
}