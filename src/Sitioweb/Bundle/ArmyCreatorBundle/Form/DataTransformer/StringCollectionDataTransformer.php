<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class StringCollectionDataTransformer implements DataTransformerInterface
{
    public function transform($value)
    {
        if (empty($value)) {
            return [];
        }

        return explode('|', $value);
    }

    public function reverseTransform($value)
    {
        if (empty($value)) {
            return '';
        }

        return implode('|', array_filter($value));
    }
}
