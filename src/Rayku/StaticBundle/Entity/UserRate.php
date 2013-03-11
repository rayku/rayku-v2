<?php

namespace Rayku\StaticBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserRate
 *
 * @ORM\Table(name="user_rate")
 * @ORM\Entity
 */
class UserRate
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="userid", type="integer", nullable=false)
     */
    private $userid;

    /**
     * @var float
     *
     * @ORM\Column(name="rate", type="decimal", nullable=false)
     */
    private $rate;



    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set userid
     *
     * @param integer $userid
     * @return UserRate
     */
    public function setUserid($userid)
    {
        $this->userid = $userid;
    
        return $this;
    }

    /**
     * Get userid
     *
     * @return integer 
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * Set rate
     *
     * @param float $rate
     * @return UserRate
     */
    public function setRate($rate)
    {
        $this->rate = $rate;
    
        return $this;
    }

    /**
     * Get rate
     *
     * @return float 
     */
    public function getRate()
    {
        return $this->rate;
    }
}