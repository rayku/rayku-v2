<?php

namespace Rayku\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserExpireMsg
 *
 * @ORM\Table(name="user_expire_msg")
 * @ORM\Entity
 */
class UserExpireMsg
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
     * @var integer
     *
     * @ORM\Column(name="expire_time", type="integer", nullable=false)
     */
    private $expireTime;



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
     * @return UserExpireMsg
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
     * Set expireTime
     *
     * @param integer $expireTime
     * @return UserExpireMsg
     */
    public function setExpireTime($expireTime)
    {
        $this->expireTime = $expireTime;
    
        return $this;
    }

    /**
     * Get expireTime
     *
     * @return integer 
     */
    public function getExpireTime()
    {
        return $this->expireTime;
    }
}