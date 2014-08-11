<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Model\Warhammer;

class W40KUnitFeature
{
    private $cc;

    private $ct;

    private $fo;

    private $en;

    private $pv;

    private $in;

    private $at;

    private $cd;

    private $svg;

    private $vav;

    private $vfl;

    private $var;

    /**
     * Gets the value of cc
     *
     * @return int
     */
    public function getCc()
    {
        return $this->cc;
    }

    /**
     * Sets the value of cc
     *
     * @param int $cc cc
     *
     * @return W40KUnitFeature
     */
    public function setCc($cc)
    {
        $this->cc = $cc;
        return $this;
    }

    /**
     * Gets the value of ct
     *
     * @return int
     */
    public function getCt()
    {
        return $this->ct;
    }

    /**
     * Sets the value of ct
     *
     * @param int $ct ct
     *
     * @return W40KUnitFeature
     */
    public function setCt($ct)
    {
        $this->ct = $ct;
        return $this;
    }

    /**
     * Gets the value of fo
     *
     * @return int
     */
    public function getFo()
    {
        return $this->fo;
    }

    /**
     * Sets the value of fo
     *
     * @param int $fo fo
     *
     * @return W40KUnitFeature
     */
    public function setFo($fo)
    {
        $this->fo = $fo;
        return $this;
    }

    /**
     * Gets the value of en
     *
     * @return int
     */
    public function getEn()
    {
        return $this->en;
    }

    /**
     * Sets the value of en
     *
     * @param int $en en
     *
     * @return W40KUnitFeature
     */
    public function setEn($en)
    {
        $this->en = $en;
        return $this;
    }

    /**
     * Gets the value of pv
     *
     * @return int
     */
    public function getPv()
    {
        return $this->pv;
    }

    /**
     * Sets the value of pv
     *
     * @param int $pv pv
     *
     * @return W40KUnitFeature
     */
    public function setPv($pv)
    {
        $this->pv = $pv;
        return $this;
    }

    /**
     * Gets the value of in
     *
     * @return int
     */
    public function getIn()
    {
        return $this->in;
    }

    /**
     * Sets the value of in
     *
     * @param int $in in
     *
     * @return W40KUnitFeature
     */
    public function setIn($in)
    {
        $this->in = $in;
        return $this;
    }

    /**
     * Gets the value of at
     *
     * @return int
     */
    public function getAt()
    {
        return $this->at;
    }

    /**
     * Sets the value of at
     *
     * @param int $at at
     *
     * @return W40KUnitFeature
     */
    public function setAt($at)
    {
        $this->at = $at;
        return $this;
    }

    /**
     * Gets the value of cd
     *
     * @return int
     */
    public function getCd()
    {
        return $this->cd;
    }

    /**
     * Sets the value of cd
     *
     * @param int $cd cd
     *
     * @return W40KUnitFeature
     */
    public function setCd($cd)
    {
        $this->cd = $cd;
        return $this;
    }

    /**
     * Gets the value of svg
     *
     * @return string
     */
    public function getSvg()
    {
        return $this->svg;
    }

    /**
     * Sets the value of svg
     *
     * @param string $svg svg
     *
     * @return W40KUnitFeature
     */
    public function setSvg($svg)
    {
        $this->svg = $svg;
        return $this;
    }

    /**
     * Gets the value of vav
     *
     * @return int
     */
    public function getVav()
    {
        return $this->vav;
    }

    /**
     * Sets the value of vav
     *
     * @param int $vav vav
     *
     * @return W40KUnitFeature
     */
    public function setVav($vav)
    {
        $this->vav = $vav;
        return $this;
    }

    /**
     * Gets the value of vfl
     *
     * @return int
     */
    public function getVfl()
    {
        return $this->vfl;
    }

    /**
     * Sets the value of vfl
     *
     * @param int $vfl
     *
     * @return W40KUnitFeature
     */
    public function setVfl($vfl)
    {
        $this->vfl = $vfl;
        return $this;
    }

    /**
     * Gets the value of var
     *
     * @return int
     */
    public function getVar()
    {
        return $this->var;
    }

    /**
     * Sets the value of var
     *
     * @param int $var var
     *
     * @return W40KUnitFeature
     */
    public function setVar($var)
    {
        $this->var = $var;
        return $this;
    }

    public function __toString()
    {
        $out = '';

        $out .= ($this->cc ? ' | Cc: ' . $this->cc : '');
        $out .= ($this->ct ? ' | Ct: ' . $this->ct : '');
        $out .= ($this->fo ? ' | Fo: ' . $this->fo : '');
        $out .= ($this->en ? ' | En: ' . $this->en : '');
        $out .= ($this->pv ? ' | Pv: ' . $this->pv : '');
        $out .= ($this->in ? ' | In: ' . $this->in : '');
        $out .= ($this->at ? ' | At: ' . $this->at : '');
        $out .= ($this->cd ? ' | Cd: ' . $this->cd : '');
        $out .= ($this->svg ? ' | Svg: ' . $this->svg : '');
        $out .= ($this->vav ? ' | V.av.: ' . $this->vav : '');
        $out .= ($this->vfl ? ' | V.fl.: ' . $this->vfl : '');
        $out .= ($this->var ? ' | V.ar.: ' . $this->var : '');


        return substr($out, 3);
    }
}
