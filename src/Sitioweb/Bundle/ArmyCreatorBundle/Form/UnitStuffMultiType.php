<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Breed;

class UnitStuffMultiType extends AbstractType
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
        $resolver->setDefaults(array(
            'type' => new UnitStuffType($this->breed),
            'translation_domain' => 'forms',
            'cascade_validation' => true,
        ));
    }

    public function getParent()
    {
        return 'collection';
    }


    /**
     * getName
     *
     * @access public
     * @return void
     */
    public function getName()
    {
        return 'armycreator_unitstuffmulti';
    }
}
