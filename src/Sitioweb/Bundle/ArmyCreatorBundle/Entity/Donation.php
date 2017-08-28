<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Donation
 *
 * @ORM\Table(indexes={@ORM\Index(name="year", columns={"year"})})
 * @ORM\Entity(repositoryClass="Sitioweb\Bundle\ArmyCreatorBundle\Entity\Repository\DonationRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Donation
{
    /**
     * @var int $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * createdAt
     *
     * @var mixed
     * @access private
     *
     * @ORM\Column(name="createdAt", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * year
     *
     * @var int
     * @access private
     *
     * @ORM\Column(name="year", type="integer", nullable=false)
     */
    private $year;

    /**
     * email
     *
     * @var string
     * @access private
     *
     * @ORM\Column(name="email", type="string", nullable=false)
     */
    private $email;

    /**
     * amount
     *
     * @var float
     * @access private
     *
     * @ORM\Column(name="amount", type="float", nullable=false)
     */
    private $amount;

    /**
     * public
     *
     * @var boolean
     * @access private
     *
     * @ORM\Column(name="isPublic", type="boolean", nullable=false)
     */
    private $public;

    /**
     * user
     *
     * @var User
     * @access private
     *
	 * @ORM\ManyToOne(targetEntity="User")
     */
    private $user;

    /**
     * __construct
     *
     * @access public
     */
    public function __construct()
    {
        $this->public = true;
    }

    /**
     * Gets the value of id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Gets the value of createdAt
     *
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Sets the value of createdAt
     *
     * @param DateTime $createdAt created date
     *
     * @return Donation
     */
    public function setCreatedAt(\DateTime $createdAt = null)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * Gets the value of year
     *
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Sets the value of year
     *
     * @param int $year year
     *
     * @return Donation
     */
    public function setYear($year)
    {
        $this->year = $year;
        return $this;
    }

    /**
     * Gets the value of email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Sets the value of email
     *
     * @param string $email email
     *
     * @return Donation
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Gets the value of amount
     *
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Sets the value of amount
     *
     * @param float $amount amount
     *
     * @return Donation
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * Gets the value of public
     *
     * @return boolean
     */
    public function isPublic()
    {
        return $this->public;
    }

    /**
     * Sets the value of public
     *
     * @param boolean $public public
     *
     * @return Donation
     */
    public function setPublic($public)
    {
        $this->public = $public;
        return $this;
    }

    /**
     * Gets the value of user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Sets the value of user
     *
     * @param User $user user
     *
     * @return Donation
     */
    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * prePersist
     *
     * @access public
     * @return void
     *
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        if (!$this->createdAt) {
            $this->createdAt = new \DateTime;
        }
        if (!$this->year) {
            $this->year = (int) $this->createdAt->format('Y');
        }
    }
}
