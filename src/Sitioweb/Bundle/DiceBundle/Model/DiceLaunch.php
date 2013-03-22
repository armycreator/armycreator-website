<?php

namespace Sitioweb\Bundle\DiceBundle\Model;

/**
 * Dice
 * 
 * @author Julien DENIAU <julien.deniau@mapado.com>
 */
class DiceLaunch {
    /**
     * diceNumber
     * 
     * @var int
     * @access public
     */
    private $diceNumber = 10;

    /**
     * wantedScore
     * 
     * @var int
     * @access public
     */
    private $wantedScore = 4;

    /**
     * Gets the value of diceNumber
     *
     * @return int
     */
    public function getDiceNumber()
    {
        return $this->diceNumber;
    }
    
    /**
     * Sets the value of diceNumber
     *
     * @param int $diceNumber dice number
     *
     * @return DiceLaunch
     */
    public function setDiceNumber($diceNumber)
    {
        $this->diceNumber = $diceNumber;
        return $this;
    }

    /**
     * Gets the value of wantedScore
     *
     * @return int
     */
    public function getWantedScore()
    {
        return $this->wantedScore;
    }
    
    /**
     * Sets the value of wantedScore
     *
     * @param int $wantedScore wantedScore
     *
     * @return DiceLaunch
     */
    public function setWantedScore($wantedScore)
    {
        $this->wantedScore = $wantedScore;
        return $this;
    }
}

