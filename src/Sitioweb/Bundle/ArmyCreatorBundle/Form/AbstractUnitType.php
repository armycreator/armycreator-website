<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Breed;
use Sitioweb\Bundle\ArmyCreatorBundle\Form\Type\FArm\UnitFeatureType as FArmUnitFeatureType;
use Sitioweb\Bundle\ArmyCreatorBundle\Form\Type\Warhammer\W40KUnitFeatureType;

abstract class AbstractUnitType extends AbstractType
{
    /**
     * breed
     *
     * @var Breed
     * @access protected
     */
    protected $breed;

    /**
     * __construct
     *
     * @param Breed $breed
     * @access public
     */
    public function __construct(Breed $breed)
    {
        $this->breed = $breed;
    }


    /**
     * addBreedSpecifics
     *
     * @access private
     * @return FormBuilderInterface
     */
    protected function addBreedSpecifics(FormBuilderInterface $builder)
    {
        switch ($this->breed->getGame()->getCode()) {
            case 'FArm':
                $builder->add('feature', new FArmUnitFeatureType);
                break;
            case 'W40K':
                $builder->add('feature', new W40KUnitFeatureType);
                break;
            default:
                break;
        }


        return $builder;
    }
}
