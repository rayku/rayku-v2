<?php

namespace Rayku\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * RaykuTutorConnect
 *
 * @ORM\Table(name="rayku_tutor_connect")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class SessionTutors
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
     * @ORM\Column(name="tutor_reply", type="string", length=255, nullable=false)
     */
    private $tutorReply;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;
    

    /**
     * @var float
     *
     * @ORM\Column(name="rate", type="decimal", nullable=false)
     * @Assert\NotNull()
     */
    private $rate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private $updatedAt;

    /**
     * @var \Session
     *
     * @ORM\ManyToOne(targetEntity="\Rayku\ApiBundle\Entity\Session", inversedBy="potential_tutors", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="session_id", referencedColumnName="id")
     * })
     * @Assert\NotNull()
     * @Assert\Type(type="\Rayku\ApiBundle\Entity\Session")
     */
    private $session;

    /**
     * @var \Tutor
     *
     * @ORM\ManyToOne(targetEntity="\Rayku\ApiBundle\Entity\Tutor")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tutor_id", referencedColumnName="id")
     * })
     * @Assert\NotNull()
     * @Assert\Type(type="\Rayku\ApiBundle\Entity\Tutor")
     */
    private $tutor;

    public function __toString()
    {
    	return $this->getTutor()->__toString();
    }

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
     * Set tutorReply
     *
     * @param string $tutorReply
     * @return SessionTutors
     */
    public function setTutorReply($tutorReply)
    {
    	// @todo move these to a static contant
    	$validOptions = array(
    		'pending',
    		'contacted gtalk',
    		'missed',
    		'replied',
    		'rejected',
    		'accepted'
    	);
    	
    	if(in_array($tutorReply, $validOptions)){
	        $this->tutorReply = $tutorReply;
    	}
    
        return $this;
    }

    /**
     * Get tutorReply
     *
     * @return string 
     */
    public function getTutorReply()
    {
        return $this->tutorReply;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return SessionTutors
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
     * @return SessionTutors
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
     * Set session
     *
     * @param \Rayku\ApiBundle\Entity\Session $session
     * @return SessionTutors
     */
    public function setSession(\Rayku\ApiBundle\Entity\Session $session = null)
    {
        $this->session = $session;
    
        return $this;
    }

    /**
     * Get session
     *
     * @return \Rayku\ApiBundle\Entity\Session 
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * Set tutor
     *
     * @param \Rayku\ApiBundle\Entity\Tutor $tutor
     * @return SessionTutors
     */
    public function setTutor(\Rayku\ApiBundle\Entity\Tutor $tutor = null)
    {
        $this->tutor = $tutor;
    
        return $this;
    }

    /**
     * Get tutor
     *
     * @return \Rayku\ApiBundle\Entity\Tutor 
     */
    public function getTutor()
    {
        return $this->tutor;
    }

    /**
     * Set rate
     *
     * @param float $rate
     * @return SessionTutors
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
     * @ORM\PrePersist
     */
    public function updateTutorData()
    {
    	$this->setRate($this->getTutor()->getRate());
    	$this->setTutorReply('pending');
    }
    
    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps()
    {
    	$this->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
    
    	if($this->getCreatedAt() == null)
    	{
    		$this->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
    	}
    }
}