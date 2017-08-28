<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Form;

use Doctrine\ORM\EntityRepository;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Breed;
use Sitioweb\Bundle\ArmyCreatorBundle\Form\Type\FArm\UnitFeatureType as FArmUnitFeatureType;
use Sitioweb\Bundle\ArmyCreatorBundle\Form\Type\Warhammer\W40KUnitFeatureType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

abstract class AbstractUnitType extends AbstractType
{
    /**
     * addBreedSpecifics
     *
     * @access private
     * @return FormBuilderInterface
     */
    protected function addBreedSpecifics(FormBuilderInterface $builder, Breed $breed)
    {
        switch ($breed->getGame()->getCode()) {
            case 'FArm':
                $builder->add('feature', FArmUnitFeatureType::class);
                break;
            case 'W40K':
                $builder->add('feature', W40KUnitFeatureType::class);
                break;
            default:
                break;
        }


        return $builder;
    }
}
