<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Form\DataTransformer\FArm;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

use Sitioweb\Bundle\ArmyCreatorBundle\Model\FArm\WeaponDescription;

class WeaponDescriptionDataTransformer implements DataTransformerInterface
{
    /**
     * transform
     * Transforms an object (issue) to a string (number).
     *
     * @param  WeaponDescription $stuffDescription
     * @return string
     */
    public function transform($stuffDescription)
    {
        if (!$stuffDescription) {
            return '';
        }

        $rangeStrengthList = $stuffDescription->getAllRangeStrength();
        $tmpOut = [];
        foreach ($rangeStrengthList as $range => $strength) {
            $tmpOut[] = sprintf('%s:%s', $range, $strength);
        }

        return implode('|', $tmpOut);
    }

    /**
     * Transforms a string (number) to an object (issue).
     *
     * @param string $stringDescription
     * @access public
     * @return StuffDescription
     * @throws TransformationFailedException if object (issue) is not found.
     */
    public function reverseTransform($stringDescription)
    {
        if (!$stringDescription) {
            return null;
        }

        $stuffDescription = new WeaponDescription;

        $tmpList = explode('|', $stringDescription);

        foreach ($tmpList as $tmp) {
            list ($range, $strength) = explode(':', $tmp);
            $stuffDescription->setRangeStrength($range, $strength);
        }

        return $stuffDescription;
    }
}
