<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Model\FArm;

class UnitFeature
{
    /**
     * dr
     *
     * @var int
     * @access private
     */
    private $dr;

    /**
     * cr
     *
     * @var int
     * @access private
     */
    private $cr;

    /**
     * mv
     *
     * @var int
     * @access private
     */
    private $mv;

    /**
     * hp
     *
     * @var int
     * @access private
     */
    private $hp;

    /**
     * cp
     *
     * @var int
     * @access private
     */
    private $cp;

    /**
     * ap
     *
     * @var int
     * @access private
     */
    private $ap;

    /**
     * pd
     *
     * @var int
     * @access private
     */
    private $pd;

    /**
     * mn
     *
     * @var int
     * @access private
     */
    private $mn;

    /**
     * Gets the value of dr
     *
     * @return int
     */
    public function getDr()
    {
        return $this->dr;
    }

    /**
     * Sets the value of dr
     *
     * @param int $dr dr
     *
     * @return UnitFeature
     */
    public function setDr($dr)
    {
        $this->dr = $dr;
        return $this;
    }

    /**
     * Gets the value of cr
     *
     * @return int
     */
    public function getCr()
    {
        return $this->cr;
    }

    /**
     * Sets the value of cr
     *
     * @param int $cr cr
     *
     * @return UnitFeature
     */
    public function setCr($cr)
    {
        $this->cr = $cr;
        return $this;
    }

    /**
     * Gets the value of mv
     *
     * @return int
     */
    public function getMv()
    {
        return $this->mv;
    }

    /**
     * Sets the value of mv
     *
     * @param int $mv mv
     *
     * @return UnitFeature
     */
    public function setMv($mv)
    {
        $this->mv = $mv;
        return $this;
    }

    /**
     * Gets the value of hp
     *
     * @return int
     */
    public function getHp()
    {
        return $this->hp;
    }

    /**
     * Sets the value of hp
     *
     * @param int $hp hp
     *
     * @return UnitFeature
     */
    public function setHp($hp)
    {
        $this->hp = $hp;
        return $this;
    }

    /**
     * Gets the value of cp
     *
     * @return int
     */
    public function getCp()
    {
        return $this->cp;
    }

    /**
     * Sets the value of cp
     *
     * @param int $cp cp
     *
     * @return UnitFeature
     */
    public function setCp($cp)
    {
        $this->cp = $cp;
        return $this;
    }

    /**
     * Gets the value of ap
     *
     * @return int
     */
    public function getAp()
    {
        return $this->ap;
    }

    /**
     * Sets the value of ap
     *
     * @param int $ap ap
     *
     * @return UnitFeature
     */
    public function setAp($ap)
    {
        $this->ap = $ap;
        return $this;
    }

    /**
     * Gets the value of pd
     *
     * @return int
     */
    public function getPd()
    {
        return $this->pd;
    }

    /**
     * Sets the value of pd
     *
     * @param int $pd pd
     *
     * @return UnitFeature
     */
    public function setPd($pd)
    {
        $this->pd = $pd;
        return $this;
    }

    /**
     * Gets the value of mn
     *
     * @return int
     */
    public function getMn()
    {
        return $this->mn;
    }

    /**
     * Sets the value of mn
     *
     * @param int $mn mn
     *
     * @return UnitFeature
     */
    public function setMn($mn)
    {
        $this->mn = $mn;
        return $this;
    }

    public function __toString()
    {
        return 'DR:' . $this->dr .
            ' | CR:' . $this->cr .
            ' | Mv:' . $this->mv .
            ' | HP:' . $this->hp .
            ' | CP:' . $this->cp .
            ' | AP:' . $this->ap .
            ' | PD:' . $this->pd .
            ' | MN:' . $this->mn
        ;
    }
}
