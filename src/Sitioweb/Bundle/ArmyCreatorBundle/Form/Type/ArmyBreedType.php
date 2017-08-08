<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Form\Type;

use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

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
     * authorizationChecker
     *
     * @var AuthorizationCheckerInterface
     * @access private
     */
    private $authorizationChecker;

    /**
     * __construct
     *
     * @param EntityManager $entityManager
     * @param AuthorizationCheckerInterface $authorizationChecker
     * @access public
     * @return void
     */
    public function __construct (EntityManager $entityManager, AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->entityManager = $entityManager;
        $this->authorizationChecker = $authorizationChecker;
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
            if (!($breed->getAvailable() || $this->authorizationChecker->isGranted('EDIT', $breed))) {
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
            'choices_as_values' => true,
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
        return 'armybreed';
    }
}
