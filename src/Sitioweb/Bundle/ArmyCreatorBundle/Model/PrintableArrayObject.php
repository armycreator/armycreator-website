<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Model;

class PrintableArrayObject extends \ArrayObject
{
    public function __get($key)
    {
        return $this->offsetGet($key);
    }

    public function __set($key, $value)
    {
        return $this->offsetSet($key, $value);
    }

    public function __toString()
    {
        $out = '';
        foreach ($this as $item) {
            $item = (string) $item;
            if (!empty($item)) {
                $out .= ' / ' . $item;
            }
        }
        return substr($out, 3);
    }
}
