<?php

namespace Rayku\TutorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * RaykuTutorConnect
 *
 * @ORM\Table(name="rayku_tutor_connect")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class TutorConnect
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
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="\Rayku\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="student_id", referencedColumnName="id")
     * })
     * @Assert\NotNull()
     */
    private $student;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="\Rayku\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tutor_id", referencedColumnName="id")
     * })
     * @Assert\NotNull()
     */
    private $tutor;

    /**
     * @var string
     *
     * @ORM\Column(name="tutor_reply", type="string", length=255, nullable=false)
     */
    private $tutorReply;

    /**
     * @var integer
     *
     * @ORM\Column(name="session_id", type="integer", nullable=true)
     */
    private $sessionId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private $updatedAt;



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
     * @return TutorConnect
     */
    public function setTutorReply($tutorReply)
    {
        $this->tutorReply = $tutorReply;
    
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
     * Set sessionId
     *
     * @param integer $sessionId
     * @return TutorConnect
     */
    public function setSessionId($sessionId)
    {
        $this->sessionId = $sessionId;
    
        return $this;
    }

    /**
     * Get sessionId
     *
     * @return integer 
     */
    public function getSessionId()
    {
        return $this->sessionId;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return TutorConnect
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
     * @return TutorConnect
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

    /**
     * Set student
     *
     * @param \Rayku\UserBundle\Entity\User $student
     * @return TutorConnect
     */
    public function setStudent(\Rayku\UserBundle\Entity\User $student = null)
    {
        $this->student = $student;
    
        return $this;
    }

    /**
     * Get student
     *
     * @return \Rayku\UserBundle\Entity\User 
     */
    public function getStudent()
    {
        return $this->student;
    }

    /**
     * Set tutor
     *
     * @param \Rayku\UserBundle\Entity\User $tutor
     * @return TutorConnect
     */
    public function setTutor(\Rayku\UserBundle\Entity\User $tutor = null)
    {
        $this->tutor = $tutor;
    
        return $this;
    }

    /**
     * Get tutor
     *
     * @return \Rayku\UserBundle\Entity\User 
     */
    public function getTutor()
    {
        return $this->tutor;
    }
}