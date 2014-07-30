<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Tests\Units\Form\DataTransformer;

use atoum;

use Sitioweb\Bundle\ArmyCreatorBundle\Form\DataTransformer\RangeStrengthTransformer as BaseTransformer;
use Sitioweb\Bundle\ArmyCreatorBundle\Model\RangeStrength;

class RangeStrengthTransformer extends atoum
{
    /**
     * testTransformWithout
     *
     * @access public
     * @return void
     */
    public function testTransformWithout()
    {
        $this
        ->if($transformer = new BaseTransformer)
        ->then
            ->variable($transformer->transform(''))
            ->isNull();

    }

    /**
     * testReverseTransformWithoutDescription
     *
     * @access public
     * @return void
     */
    public function testReverseTransformWithoutDescription()
    {
        $this
        ->if($transformer = new BaseTransformer)
        ->then
            ->string($transformer->reverseTransform(null))
            ->isEmpty();

        $this
        ->if($transformer = new BaseTransformer)
        ->and($description = new RangeStrength)
        ->and(
        )
        ->then
            ->string($transformer->reverseTransform($description))
            ->isEqualTo('');
    }

    /**
     * testTransformWithValues
     *
     * @access public
     * @return void
     */
    public function testTransformWithValues()
    {
        $this
        ->if($transformer = new BaseTransformer)
        ->then
            ->object($description = $transformer->transform('12:22'))
            ->isInstanceOf('Sitioweb\Bundle\ArmyCreatorBundle\Model\RangeStrength')
        ->then
            ->variable($description->getRange())
            ->isEqualTo(12)
            ->variable($description->getStrength())
            ->isEqualTo(22)
        ;

    }

    /**
     * testReverseTransformWithDescription
     *
     * @access public
     * @return void
     */
    public function testReverseTransformWithDescription()
    {
        $this
        ->if($transformer = new BaseTransformer)
        ->and($description = new RangeStrength)
        ->and(
            $description->setRange(12)
                ->setStrength(39)
        )
        ->then
            ->string($transformer->reverseTransform($description))
            ->isEqualTo('12:39');
    }
}
