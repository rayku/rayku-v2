<?php

namespace Rayku\SessionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RaykuSession
 *
 * @ORM\Table(name="rayku_session")
 * @ORM\Entity
 */
class RaykuSession
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
     * @ORM\Column(name="start_time", type="datetime", nullable=false)
     */
    private $startTime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_time", type="datetime", nullable=false)
     */
    private $endTime;

    /**
     * @var integer
     *
     * @ORM\Column(name="duration", type="integer", nullable=false)
     */
    private $duration;

    /**
     * @var integer
     *
     * @ORM\Column(name="rating", type="integer", nullable=false)
     */
    private $rating;

    /**
     * @var float
     *
     * @ORM\Column(name="rate", type="decimal", nullable=false)
     */
    private $rate;

    /**
     * @var string
     *
     * @ORM\Column(name="question", type="string", length=1000, nullable=false)
     */
    private $question;

    /**
     * @var integer
     *
     * @ORM\Column(name="recording_id", type="integer", nullable=false)
     */
    private $recordingId;

    /**
     * @var \FosUserUser
     *
     * @ORM\ManyToOne(targetEntity="FosUserUser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="email", referencedColumnName="email_canonical")
     * })
     */
    private $email;

    /**
     * @var \FosUserUser
     *
     * @ORM\ManyToOne(targetEntity="\Rayku\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="student_id", referencedColumnName="id")
     * })
     */
    private $student;

    /**
     * @var \FosUserUser
     *
     * @ORM\ManyToOne(targetEntity="\Rayku\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tutor_id", referencedColumnName="id")
     * })
     */
    private $tutor;

    /**
     * @var \FosUserUser
     *
     * @ORM\ManyToOne(targetEntity="\Rayku\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="username", referencedColumnName="username_canonical")
     * })
     */
    private $username;



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
     * @return RaykuSession
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
     * @return RaykuSession
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
     * @return RaykuSession
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
     * @return RaykuSession
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
     * @return RaykuSession
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
     * @return RaykuSession
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
     * @return RaykuSession
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
     * @param \Rayku\UserBundle\Entity\User $email
     * @return RaykuSession
     */
    public function setEmail(\Rayku\SessionBundle\Entity\FosUserUser $email = null)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return \Rayku\UserBundle\Entity\User 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set student
     *
     * @param \Rayku\UserBundle\Entity\User $student
     * @return RaykuSession
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
     * @return RaykuSession
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

    /**
     * Set username
     *
     * @param \Rayku\UserBundle\Entity\User $username
     * @return RaykuSession
     */
    public function setUsername(\Rayku\UserBundle\Entity\User $username = null)
    {
        $this->username = $username;
    
        return $this;
    }

    /**
     * Get username
     *
     * @return \Rayku\UserBundle\Entity\User
     */
    public function getUsername()
    {
        return $this->username;
    }
}