<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Form\Type;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

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
     * securityContext
     *
     * @var SecurityContextInterface
     * @access private
     */
    private $securityContext;

    /**
     * __construct
     *
     * @param EntityManager $entityManager
     * @param SecurityContextInterface $securityContext
     * @access public
     * @return void
     */
    public function __construct (EntityManager $entityManager, SecurityContextInterface $securityContext)
    {
        $this->entityManager = $entityManager;
        $this->securityContext = $securityContext;
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
        //$breedList = $this->getUserBreed();

        $repository = $this->entityManager
            ->getRepository('SitiowebArmyCreatorBundle:Breed');

        $breedList = $repository->createQueryBuilder('b')
                ->leftJoin('b.game', 'g')
                ->add('orderBy', 'g.code, b.name ASC')
                ->getQuery()
                ->getResult();

        $choices = [];
        foreach ($breedList as $breed) {
            if (!($breed->getAvailable() || $this->securityContext->isGranted('EDIT', $breed))) {
                continue;
            }

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
