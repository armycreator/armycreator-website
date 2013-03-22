<?php

namespace Sitioweb\Bundle\DiceBundle\Model;

/**
 * Infight
 * 
 * @author Julien DENIAU <julien.deniau@mapado.com>
 */
class Infight {
    /**
     * unitNumber
     * 
     * @var int
     * @access public
     */
    private $unitNumber = 10;

    private $hitByUnit = 1;

    private $supplementaryHit = false;
    
    private $weaponSkill = 0;

    private $opponentWeaponSkill = 0;

    private $strength = 0;

    private $toughness = 0;

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
     * @return Infight
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
    public function getHitByUnit()
    {
        return $this->hitByUnit;
    }
    
    /**
     * Sets the value of hitByUnit
     *
     * @param int $hitByUnit description
     *
     * @return Infight
     */
    public function setHitByUnit($hitByUnit)
    {
        $this->hitByUnit = $hitByUnit;
        return $this;
    }

    /**
     * Gets the value of supplementaryHit
     *
     * @return boolean
     */
    public function getSupplementaryHit()
    {
        return $this->supplementaryHit;
    }
    
    /**
     * Sets the value of supplementaryHit
     *
     * @param boolean $supplementaryHit description
     *
     * @return Infight
     */
    public function setSupplementaryHit($supplementaryHit)
    {
        $this->supplementaryHit = $supplementaryHit;
        return $this;
    }

    /**
     * Gets the value of weaponSkill
     *
     * @return int
     */
    public function getWeaponSkill()
    {
        return max(0, min(10, $this->weaponSkill));
    }
    
    /**
     * Sets the value of weaponSkill
     *
     * @param int $weaponSkill description
     *
     * @return Infight
     */
    public function setWeaponSkill($weaponSkill)
    {
        $this->weaponSkill = $weaponSkill;
        return $this;
    }

    /**
     * Gets the value of opponentWeaponSkill
     *
     * @return int
     */
    public function getOpponentWeaponSkill()
    {
        return max(0, min(10, $this->opponentWeaponSkill));
    }
    
    /**
     * Sets the value of opponentWeaponSkill
     *
     * @param int $opponentWeaponSkill description
     *
     * @return Infight
     */
    public function setOpponentWeaponSkill($opponentWeaponSkill)
    {
        $this->opponentWeaponSkill = $opponentWeaponSkill;
        return $this;
    }

    /**
     * Gets the value of Strength
     *
     * @return int
     */
    public function getStrength()
    {
        return $this->strength;
    }
    
    /**
     * Sets the value of Strength
     *
     * @param int $Strength description
     *
     * @return Infight
     */
    public function setStrength($strength)
    {
        $this->strength = $strength;
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
     * @return Infight
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
     * @return Infight
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
     * @return Infight
     */
    public function setSecondSave($secondSave)
    {
        $this->secondSave = $secondSave;
        return $this;
    }

    /**
     * getHitNumber
     *
     * @access public
     * @return int
     */
    public function getHitNumber()
    {
        $hitByUnit = $this->getHitByUnit();
        if ($this->getSupplementaryHit() === true) {
            $hitByUnit++;
        }
        return $this->getUnitNumber() * $hitByUnit;
    }

    /**
     * getStats
     *
     * @access public
     * @return float
     */
    public function getStats()
    {
        $ws = $this->getWeaponSkill();
        $ows = $this->getOpponentWeaponSkill();

        if ($ws > $ows) {
            $touchPercentage = 2/3;
        } elseif($ows > 2 * $ws) {
            $touchPercentage = 1/3;
        } else {
            $touchPercentage = 0.5;
        }

        // hit
        $hitNumber = $this->getHitNumber() * $touchPercentage;

        // wounded number
        $diffST = $this->getStrength() - $this->getToughness();
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
            case -3 : 
                $woundedPercentage = 1/6;
                break;
            default : 
                $woundedPercentage = 0;
                break;
        }
        $wounded = $hitNumber * $woundedPercentage;


        // save 1
        $savePercentage = ($this->getSave() - 1) / 6; //Svg 3+ = 2 sides on 6 = dead  /   Svg 5+ = 4 sides 6 = dead

        // hits after save
        $saveNumber = $wounded * $savePercentage;

        // second save
        $secondSavePercentage = ($this->getSecondSave() - 1) / 6;

        // nombre de touches après svg2
        $nb = $saveNumber * $secondSavePercentage;

        return $nb;
    }
}

