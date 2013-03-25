<?php

namespace Rayku\SessionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Session
 *
 * @ORM\Table(name="rayku_session")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Session
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
     * @var \DateTime
     *
     * @ORM\Column(name="start_time", type="datetime", nullable=true)
     * @Assert\DateTime()
     */
    private $startTime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_time", type="datetime", nullable=true)
     * @Assert\DateTime()
     */
    private $endTime;

    /**
     * @var integer
     *
     * @ORM\Column(name="duration", type="integer", nullable=true)
     */
    private $duration;

    /**
     * @var integer
     *
     * @ORM\Column(name="rating", type="integer", nullable=true)
     */
    private $rating;

    /**
     * @var float
     *
     * @ORM\Column(name="rate", type="decimal", nullable=true)
     */
    private $rate;

    /**
     * @var string
     *
     * @ORM\Column(name="question", type="string", length=1000, nullable=true)
     */
    private $question;

    /**
     * @var integer
     *
     * @ORM\Column(name="recording_id", type="integer", nullable=true)
     */
    private $recordingId;
    
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
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="\Rayku\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="student_id", referencedColumnName="id")
     * })
     * @Assert\NotNull()
     * @Assert\Type(type="\Rayku\UserBundle\Entity\User")
     */
    private $student;
    

    /**
     * @var \RaykuSession
     *
     * @ORM\OneToMany(targetEntity="\Rayku\SessionBundle\Entity\SessionTutors", mappedBy="session", cascade={"persist", "remove"})
     */
    private $tutors;
    
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
     * Set startTime
     *
     * @param \DateTime $startTime
     * @return Session
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;
    
        return $this;
    }

    /**
     * Get startTime
     *
     * @return \DateTime 
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * Set endTime
     *
     * @param \DateTime $endTime
     * @return Session
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;
    
        return $this;
    }

    /**
     * Get endTime
     *
     * @return \DateTime 
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * Set duration
     *
     * @param integer $duration
     * @return Session
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;
    
        return $this;
    }

    /**
     * Get duration
     *
     * @return integer 
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set rating
     *
     * @param integer $rating
     * @return Session
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
    
        return $this;
    }

    /**
     * Get rating
     *
     * @return integer 
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Set rate
     *
     * @param float $rate
     * @return Session
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
     * Set question
     *
     * @param string $question
     * @return Session
     */
    public function setQuestion($question)
    {
        $this->question = $question;
    
        return $this;
    }

    /**
     * Get question
     *
     * @return string 
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set recordingId
     *
     * @param integer $recordingId
     * @return Session
     */
    public function setRecordingId($recordingId)
    {
        $this->recordingId = $recordingId;
    
        return $this;
    }

    /**
     * Get recordingId
     *
     * @return integer 
     */
    public function getRecordingId()
    {
        return $this->recordingId;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Session
     */
    public function setEmail($email = null)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set student
     *
     * @param \Rayku\UserBundle\Entity\User $student
     * @return Session
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
     * Set username
     *
     * @param string $username
     * @return Session
     */
    public function setUsername($username = null)
    {
        $this->username = $username;
    
        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Session
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
     * @return Session
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
     * Constructor
     */
    public function __construct()
    {
        $this->tutors = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add tutors
     *
     * @param \Rayku\SessionBundle\Entity\SessionTutors $tutors
     * @return Session
     */
    public function addTutor(\Rayku\SessionBundle\Entity\SessionTutors $tutors)
    {
        $this->tutors[] = $tutors;
    
        return $this;
    }

    /**
     * Remove tutors
     *
     * @param \Rayku\SessionBundle\Entity\SessionTutors $tutors
     */
    public function removeTutor(\Rayku\SessionBundle\Entity\SessionTutors $tutors)
    {
        $this->tutors->removeElement($tutors);
    }

    /**
     * Get tutors
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTutors()
    {
        return $this->tutors;
    }
}