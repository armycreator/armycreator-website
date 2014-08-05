<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Tests\Units\Form\DataTransformer;

use atoum;

use Sitioweb\Bundle\ArmyCreatorBundle\Form\DataTransformer\StringCollectionDataTransformer as BaseTransformer;
use Sitioweb\Bundle\ArmyCreatorBundle\Model\RangeStrength;

class StringCollectionDataTransformer extends atoum
{
    /**
     * testTransform
     *
     * @access public
     * @return void
     */
    public function testTransform()
    {
        $this
            ->if($transformer = new BaseTransformer)
            ->then
                ->array($transformer->transform(null))
                ->isEmpty()
            ->then
                ->array($values = $transformer->transform('a|bab'))
                ->size->isEqualTo(2)
                ->string($values[0])
                    ->isEqualTo('a')
                ->string($values[1])
                    ->isEqualTo('bab')
        ;
    }

    /**
     * testReverseTransform
     *
     * @access public
     * @return void
     */
    public function testReverseTransform()
    {
        $this
            ->if($transformer = new BaseTransformer)
            ->then
                ->string($transformer->reverseTransform(null))
                ->isEmpty()
                ->string($transformer->reverseTransform([]))
                ->isEmpty()
            ->then
                ->string($transformer->reverseTransform(['ba', 'bo']))
                ->isEqualTo('ba|bo')
            ->then
                ->string($transformer->reverseTransform(['ba', 'bo', '', '']))
                ->isEqualTo('ba|bo')
        ;
    }
}
