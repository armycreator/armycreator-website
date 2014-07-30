<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

use Sitioweb\Bundle\ArmyCreatorBundle\Model\RangeStrength;

class RangeStrengthTransformer implements DataTransformerInterface
{
    /**
     * Transforms normalized data to view data
     *
     * @param  string $stringDescription
     * @return RangeStrength|null
     */
    public function transform($stringDescription)
    {
        if (!$stringDescription) {
            return null;
        }

        $rangeStrength = new RangeStrength;

        list ($range, $strength) = explode(':', $stringDescription);
        $rangeStrength->setRange($range)
            ->setStrength($strength);

        return $rangeStrength;
    }

    /**
     * Transforms view data to normalized data
     *
     * @param mixed $rangeStrength
     * @access public
     * @return string
     */
    public function reverseTransform($rangeStrength)
    {
        if (!$rangeStrength) {
            return '';
        }

        $output = sprintf('%s:%s', $rangeStrength->getRange(), $rangeStrength->getStrength());

        if ($output === ':') {
            return '';
        }

        return $output;
    }
}
