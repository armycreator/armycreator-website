<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Form\Type;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArmyBreedType extends AbstractType
{
    /**
     * entityManager
     *
     * @var EntityManager
     * @access private
     */
    private $entityManager;

    /**
     * __construct
     *
     * @param EntityManager $entityManager
     * @access public
     * @return void
     */
    public function __construct (EntityManager $entityManager) {
        $this->entityManager = $entityManager;
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
        $repository = $this->entityManager
            ->getRepository('SitiowebArmyCreatorBundle:Breed');

        $breedList = $repository->createQueryBuilder('b')
                ->leftJoin('b.game', 'g')
                ->where('b.available = :available')
                ->add('orderBy', 'g.code, b.name ASC')
                ->setParameter('available', true)
                ->getQuery()
                ->getResult();

        $choices = [];
        foreach ($breedList as $breed) {
            if (!isset($choices[$breed->getGame()->getName()])) {
                $choices[$breed->getGame()->getName()] = [];
            }
            $choices[$breed->getGame()->getName()][$breed->getId()] = $breed;
        }


        $resolver->setDefaults([
            'class' => 'Sitioweb\Bundle\ArmyCreatorBundle\Entity\Breed',
            'choices' => $choices,
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
        return 'armybreed';
    }
}
