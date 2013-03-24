<?php

namespace Rayku\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Entity\User as BaseUser;

/**
 * User
 *
 * @ORM\Table(name="fos_user_user")
 * @ORM\Entity
 */
class User extends BaseUser
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="online_web", type="datetime", nullable=true)
	 */
	private $onlineWeb;
	
	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="online_gchat", type="datetime", nullable=true)
	 */
	private $onlineGchat;

	/**
	 * @var \User
	 *
	 * @ORM\OneToOne(targetEntity="\Rayku\TutorBundle\Entity\Tutor")
	 * @ORM\JoinColumn(name="tutor_id", referencedColumnName="id")
	 */
	private $tutor;
	
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
     * Set onlineWeb
     *
     * @param \DateTime $onlineWeb
     * @return User
     */
    public function setOnlineWeb($onlineWeb)
    {
        $this->onlineWeb = $onlineWeb;
    
        return $this;
    }

    /**
     * Get onlineWeb
     *
     * @return \DateTime 
     */
    public function getOnlineWeb()
    {
        return $this->onlineWeb;
    }

    /**
     * Set onlineGchat
     *
     * @param \DateTime $onlineGchat
     * @return User
     */
    public function setOnlineGchat($onlineGchat)
    {
        $this->onlineGchat = $onlineGchat;
    
        return $this;
    }

    /**
     * Get onlineGchat
     *
     * @return \DateTime 
     */
    public function getOnlineGchat()
    {
        return $this->onlineGchat;
    }

    /**
     * Set tutor
     *
     * @param \Rayku\TutorBundle\Entity\Tutor $tutor
     * @return User
     */
    public function setTutor(\Rayku\TutorBundle\Entity\Tutor $tutor = null)
    {
        $this->tutor = $tutor;
    
        return $this;
    }

    /**
     * Get tutor
     *
     * @return \Rayku\TutorBundle\Entity\Tutor 
     */
    public function getTutor()
    {
        return $this->tutor;
    }
}