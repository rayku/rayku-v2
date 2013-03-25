<?php

namespace Rayku\TutorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Tutor
 *
 * @ORM\Table(name="rayku_tutor",uniqueConstraints={@ORM\UniqueConstraint(name="user_idx", columns={"user_id"})})
 * @ORM\Entity
 */
class Tutor
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
     * @var string
     *
     * @Assert\NotBlank
     * @ORM\Column(name="school_name", type="string", length=255, nullable=true)
     */
    private $schoolName;

    /**
     * @var string
     *
     * @Assert\NotBlank
     * @ORM\Column(name="school_amount", type="string", length=255, nullable=true)
     */
    private $schoolAmount;

    /**
     * @var boolean
     *
     * @ORM\Column(name="online_web", type="boolean", nullable=true)
     */
    private $onlineWeb;

    /**
     * @var boolean
     *
     * @ORM\Column(name="online_gchat", type="boolean", nullable=true)
     */
    private $onlineGchat;

    /**
     * @var float
     *
     * @Assert\NotBlank
     * @Assert\Min(limit = 0, message = "You can't have a rate less than 0.")
     * @Assert\Max(limit = 500, message = "Highest rate available is 500.")
     * @ORM\Column(name="rate", type="float", nullable=true)
     */
    private $rate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var \User
     *
     * @ORM\OneToOne(targetEntity="\Rayku\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;


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
     * Set schoolName
     *
     * @param string $schoolName
     * @return Tutor
     */
    public function setSchoolName($schoolName)
    {
        $this->schoolName = $schoolName;
    
        return $this;
    }

    /**
     * Get schoolName
     *
     * @return string 
     */
    public function getSchoolName()
    {
        return $this->schoolName;
    }

    /**
     * Set schoolAmount
     *
     * @param string $schoolAmount
     * @return Tutor
     */
    public function setSchoolAmount($schoolAmount)
    {
        $this->schoolAmount = $schoolAmount;
    
        return $this;
    }

    /**
     * Get schoolAmount
     *
     * @return string 
     */
    public function getSchoolAmount()
    {
        return $this->schoolAmount;
    }

    /**
     * Set onlineWeb
     *
     * @param boolean $onlineWeb
     * @return Tutor
     */
    public function setOnlineWeb($onlineWeb)
    {
        $this->onlineWeb = $onlineWeb;
    
        return $this;
    }

    /**
     * Get onlineWeb
     *
     * @return boolean 
     */
    public function getOnlineWeb()
    {
        return $this->onlineWeb;
    }

    /**
     * Set onlineGchat
     *
     * @param boolean $onlineGchat
     * @return Tutor
     */
    public function setOnlineGchat($onlineGchat)
    {
        $this->onlineGchat = $onlineGchat;
    
        return $this;
    }

    /**
     * Get onlineGchat
     *
     * @return boolean 
     */
    public function getOnlineGchat()
    {
        return $this->onlineGchat;
    }

    /**
     * Set rate
     *
     * @param float $rate
     * @return Tutor
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

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Tutor
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Tutor
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    
        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set user
     *
     * @param \Rayku\UserBundle\Entity\User $user
     * @return Tutor
     */
    public function setUser(\Rayku\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \Rayku\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}