<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Tests\Units\Form\DataTransformer\FArm;

use atoum;

use Sitioweb\Bundle\ArmyCreatorBundle\Form\DataTransformer\FArm\WeaponDescriptionDataTransformer as BaseTransformer;
use Sitioweb\Bundle\ArmyCreatorBundle\Model\FArm\WeaponDescription;

class WeaponDescriptionDataTransformer extends atoum
{
    /**
     * testTransformWithoutDescription
     *
     * @access public
     * @return void
     */
    public function testTransformWithoutDescription()
    {
        $this
        ->if($transformer = new BaseTransformer)
        ->then
            ->string($transformer->transform(null))
            ->isEmpty();

        $this
        ->if($transformer = new BaseTransformer)
        ->and($description = new WeaponDescription)
        ->and(
        )
        ->then
            ->string($transformer->transform($description))
            ->isEqualTo('');
    }

    /**
     * testReverseTransformWithout
     *
     * @access public
     * @return void
     */
    public function testReverseTransformWithout()
    {
        $this
        ->if($transformer = new BaseTransformer)
        ->then
            ->variable($transformer->reverseTransform(''))
            ->isNull();

    }

    /**
     * testTransformWithDescription
     *
     * @access public
     * @return void
     */
    public function testTransformWithDescription()
    {
        $this
        ->if($transformer = new BaseTransformer)
        ->and($description = new WeaponDescription)
        ->and(
            $description->setRangeStrength(12, 12)
                ->setRangeStrength(24, 14)
                ->setRangeStrength(36, 10)
                ->setRangeStrength(48, 8)
        )
        ->then
            ->string($transformer->transform($description))
            ->isEqualTo('12:12|24:14|36:10|48:8');
    }

    /**
     * testReverseTransformWithValues
     *
     * @access public
     * @return void
     */
    public function testReverseTransformWithValues()
    {
        $this
        ->if($transformer = new BaseTransformer)
        ->then
            ->object($description = $transformer->reverseTransform('12:12|24:14|36:10|48:8'))
            ->isInstanceOf('Sitioweb\Bundle\ArmyCreatorBundle\Model\FArm\WeaponDescription')
        ->then
            ->array($description->getAllRangeStrength())
            ->isEqualTo([12 => 12, 24 => 14, 36 => 10, 48 => 8])
        ;

    }
}
