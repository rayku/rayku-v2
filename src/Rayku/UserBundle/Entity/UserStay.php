<?php

namespace Rayku\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserStay
 *
 * @ORM\Table(name="user_stay")
 * @ORM\Entity
 */
class UserStay
{
    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $userId;

    /**
     * @var integer
     *
     * @ORM\Column(name="time", type="integer", nullable=false)
     */
    private $time;

    /**
     * @var integer
     *
     * @ORM\Column(name="stay", type="integer", nullable=false)
     */
    private $stay;



    /**
     * Get userId
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set time
     *
     * @param integer $time
     * @return UserStay
     */
    public function setTime($time)
    {
        $this->time = $time;
    
        return $this;
    }

    /**
     * Get time
     *
     * @return integer 
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set stay
     *
     * @param integer $stay
     * @return UserStay
     */
    public function setStay($stay)
    {
        $this->stay = $stay;
    
        return $this;
    }

    /**
     * Get stay
     *
     * @return integer 
     */
    public function getStay()
    {
        return $this->stay;
    }
}