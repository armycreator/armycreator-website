<?php

namespace Sitioweb\Bundle\DiceBundle\Model;

/**
 * ShotFired
 * 
 * @author Julien DENIAU <julien.deniau@mapado.com>
 */
class ShotFired {
    /**
     * unitNumber
     * 
     * @var int
     * @access public
     */
    private $unitNumber = 10;

    private $shotsByUnit = 1;
    
    private $ballisticSkill = 0;

    private $weaponStrength = 0;

    private $toughness = 4;

    private $save = null;

    private $secondSave = null;

    /**
     * Gets the value of unitNumber
     *
     * @return int
     */
    public function getUnitNumber()
    {
        return $this->unitNumber;
    }
    
    /**
     * Sets the value of unitNumber
     *
     * @param int $unitNumber description
     *
     * @return ShotFired
     */
    public function setUnitNumber($unitNumber)
    {
        $this->unitNumber = $unitNumber;
        return $this;
    }
    
    /**
     * Gets the value of shotsByUnit
     *
     * @return int
     */
    public function getShotsByUnit()
    {
        return $this->shotsByUnit;
    }
    
    /**
     * Sets the value of shotsByUnit
     *
     * @param int $shotsByUnit description
     *
     * @return ShotFired
     */
    public function setShotsByUnit($shotsByUnit)
    {
        $this->shotsByUnit = $shotsByUnit;
        return $this;
    }

    /**
     * Gets the value of ballisticSkill
     *
     * @return int
     */
    public function getBallisticSkill()
    {
        return $this->ballisticSkill;
    }
    
    /**
     * Sets the value of ballisticSkill
     *
     * @param int $ballisticSkill description
     *
     * @return ShotFired
     */
    public function setBallisticSkill($ballisticSkill)
    {
        $this->ballisticSkill = $ballisticSkill;
        return $this;
    }

    /**
     * Gets the value of weaponStrength
     *
     * @return int
     */
    public function getWeaponStrength()
    {
        return $this->weaponStrength;
    }
    
    /**
     * Sets the value of weaponStrength
     *
     * @param int $weaponStrength description
     *
     * @return ShotFired
     */
    public function setWeaponStrength($weaponStrength)
    {
        $this->weaponStrength = $weaponStrength;
        return $this;
    }

    /**
     * Gets the value of toughness
     *
     * @return int
     */
    public function getToughness()
    {
        return $this->toughness;
    }
    
    /**
     * Sets the value of toughness
     *
     * @param int $toughness description
     *
     * @return ShotFired
     */
    public function setToughness($toughness)
    {
        $this->toughness = $toughness;
        return $this;
    }

    /**
     * Gets the value of save
     *
     * @return int
     */
    public function getSave()
    {
        $save = $this->save;
        if ($save > 6 || $save <= 0) {
            $save = 7;
        } elseif ($save < 2) {
            $save = 2;
        }   
        return $save;
    }
    
    /**
     * Sets the value of save
     *
     * @param int $save save
     *
     * @return ShotFired
     */
    public function setSave($save)
    {
        $this->save = $save;
        return $this;
    }

    /**
     * Gets the value of secondSave
     *
     * @return int
     */
    public function getSecondSave()
    {
        $save = $this->secondSave;
        if ($save > 6 || $save <= 0) {
            $save = 7;
        } elseif ($save < 2) {
            $save = 2;
        }   
        return $save;
    }
    
    /**
     * Sets the value of secondSave
     *
     * @param int $secondSave description
     *
     * @return ShotFired
     */
    public function setSecondSave($secondSave)
    {
        $this->secondSave = $secondSave;
        return $this;
    }

    /**
     * getShotNumber
     *
     * @access public
     * @return int
     */
    public function getShotNumber()
    {
        return $this->getUnitNumber() * $this->getShotsByUnit();
    }

    /**
     * getStats
     *
     * @access public
     * @return float
     */
    public function getStats()
    {
        $bs = $this->getBallisticSkill();


        if ($bs >= 6) {
            $bs = 5;
        } elseif ($bs < 0) {
            $bs = 0;
        }   
        $tPercent = ($bs / 6);   // if BS = 5, touch is made on 2+, so 5 sides on 7 / if BS = 3, touch is made on 4+, so 3 sides on 6, etc.

        // number of touches
        $touches = $this->getShotNumber() * $tPercent;

        // nombre de blessés
        $diffST = $this->getWeaponStrength() - $this->getToughness();
        $diffST = ($diffST > 2) ? 2 : $diffST;
        switch($diffST) {
            case 2 :
                $woundedPercentage = 5/6;
                break;
            case 1 :
                $woundedPercentage = 4/6;
                break;
            case 0 :
                $woundedPercentage = 3/6;
                break;
            case -1 :
                $woundedPercentage = 2/6;
                break;
            case -2 :
                $woundedPercentage = 1/6;
                break;
            default :
                $woundedPercentage = 0;
                break;
        }   
        $wounded = $touches * $woundedPercentage;


        $savePercentage = ($this->getSave() - 1) / 6; //Svg 3+ = 2 sides on 6 = dead  /   Svg 5+ = 4 sides 6 = dead
        // touch number after save
        $saveNumber = $wounded * $savePercentage;

        // second save
        $secondSavePercentage = ($this->getSecondSave() - 1) / 6;
        // touch number after second save
        $nb = $saveNumber * $secondSavePercentage;                        

        return $nb;
    }
}
