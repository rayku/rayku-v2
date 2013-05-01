<?php

namespace Rayku\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Session
 *
 * @ORM\Entity(repositoryClass="Rayku\ApiBundle\Entity\SessionRepository")
 * @ORM\Table(name="rayku_session")
 * @ORM\HasLifecycleCallbacks
 */
class Session
{
	const expire_session = '-10 minutes';
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
    private $question = 'To be discussed';

    /**
     * @var integer
     *
     * @ORM\Column(name="recording_id", type="integer", nullable=true)
     */
    private $recordingId;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="\Rayku\ApiBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="student_id", referencedColumnName="id")
     * })
     * @Assert\Type(type="\Rayku\ApiBundle\Entity\User")
     */
    private $student;
    
    /**
     * @var \Subject
     * 
     * @ORM\ManyToOne(targetEntity="\Rayku\ApiBundle\Entity\Subject")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="subject_id", referencedColumnName="id")
     * })
     * @Assert\Type(type="\Rayku\ApiBundle\Entity\Subject")
     * @Assert\Valid
     */
    private $subject;
    

    /**
     * @var \RaykuSession
     *
     * @ORM\OneToMany(targetEntity="\Rayku\ApiBundle\Entity\SessionTutors", mappedBy="session", cascade={"persist", "remove"})
     */
    private $potential_tutors;
    
    /**
     * @var \Tutor
     * 
     * @ORM\ManyToOne(targetEntity="\Rayku\ApiBundle\Entity\Tutor")
     * @ORM\JoinColumn(name="selected_tutor_id", referencedColumnName="id")
     */
    private $selected_tutor;
    
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
    
    public function __toString()
    {
    	return $this->getId().' '.$this->getCreatedAt()->format('Y-m-d H:i:s');
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
    	if(!empty($question)){
	        $this->question = $question;
    	}
    
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
     * @param \Rayku\ApiBundle\Entity\User $student
     * @return Session
     */
    public function setStudent(\Rayku\ApiBundle\Entity\User $student = null)
    {
        $this->student = $student;
    
        return $this;
    }

    /**
     * Get student
     *
     * @return \Rayku\ApiBundle\Entity\User 
     */
    public function getStudent()
    {
        return $this->student;
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
    
    public function endNow()
    {
    	if(null !== $this->getEndTime()){
    		return $this;
    	}
    	
    	$currentDate = new \DateTime(date('Y-m-d H:i:s'));
    	$duration = $currentDate->diff($this->getStartTime());
    	
    	// @todo should this move to the model or a event?
    	$minutes = $duration->days * 24 * 60;
    	$minutes += $duration->h * 60;
    	$minutes += $duration->i;
    	
    	$this->setDuration($minutes);
    	$this->setEndTime($currentDate);
    	$points = $minutes * $this->getRate();
    	$this->getSelectedTutor()->getUser()->addPoints($points);
    	$this->getStudent()->subtractPoints($points);
    	$this->setUsersBusy();
    	
    	return $this;
    }
    
    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     * @todo emit and catch a end session event
     */
    public function setUsersBusy()
    {
    	// Mark tutors that don't respond to tutoring requests as busy
    	$busy = new \DateTime('+40 minutes');
    	$notBusy = new \DateTime(self::expire_session);
    	foreach($this->getPotentialTutors() as $potential_tutor)
    	{
    		if(in_array($potential_tutor->getTutorReply(), array('pending', 'contacted gtalk', 'accepted'))){
	    		$potential_tutor->getTutor()->setBusy($busy);
    		}else{
    			$potential_tutor->getTutor()->setBusy($notBusy);
    		}
    	}
    	
    	$busy = new \DateTime();
    	
    	// Mark tutors that don't respond to tutoring requests as busy
    	$busy->modify('+40 minutes');
    	foreach($this->getPotentialTutors() as $potential_tutor)
    	{
    		$potential_tutor->getTutor()->setBusy($busy);
    	}
    	
    	$busy = new \DateTime();
    	$notBusy = new \DateTime(self::expire_session);
    	
    	$tutor = $this->getSelectedTutor();
    	$student = $this->getStudent()->getTutor();
    	if($this->getId() == null){ // New Session mark student as busy
    		$student->setBusy($busy);
    	}else if($this->getStartTime() === null && $this->getEndTime() === null && $this->getCreatedAt() > new \DateTime(self::expire_session)){ // Old expired session
    		$student->setBusy($notBusy);
    		if(!is_null($tutor)) $tutor->setBusy($notBusy);
    	}else if($this->getStartTime() !== null && $this->getEndTime() === null){ // Active session with a start and no end
    		$student->setBusy($busy);
    		if(!is_null($tutor)) $tutor->setBusy($busy);
    	}else if($this->getStartTime() !== null && $this->getEndTime() !== null){ // Session that was started and ended
    		$student->setBusy($notBusy);
    		if(!is_null($tutor)) $tutor->setBusy($notBusy);
    	}
    	
    	return $this;
    }
    
    public function updatedTimestamps()
    {
    	$this->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
    
    	if($this->getCreatedAt() == null)
    	{
    		$this->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
    	}
    	
    	return $this;
    }
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tutors = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set subject
     *
     * @param \Rayku\ApiBundle\Entity\Tutor $subject
     * @return Session
     */
    public function setSubject(\Rayku\ApiBundle\Entity\Tutor $subject = null)
    {
        $this->subject = $subject;
    
        return $this;
    }

    /**
     * Get subject
     *
     * @return \Rayku\ApiBundle\Entity\Tutor 
     */
    public function getSubject()
    { 	
        return $this->subject;
    }

    /**
     * Add potential_tutors
     *
     * @param \Rayku\ApiBundle\Entity\SessionTutors $potentialTutors
     * @return Session
     */
    public function addPotentialTutor(\Rayku\ApiBundle\Entity\SessionTutors $potentialTutor)
    {
	    $this->potential_tutors[] = $potentialTutor->setSession($this);
    
        return $this;
    }

    /**
     * Remove potential_tutors
     *
     * @param \Rayku\ApiBundle\Entity\SessionTutors $potentialTutors
     */
    public function removePotentialTutor(\Rayku\ApiBundle\Entity\SessionTutors $potentialTutors)
    {
        $this->potential_tutors->removeElement($potentialTutors);
    }

    /**
     * Get potential_tutors
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPotentialTutors()
    {
        return $this->potential_tutors;
    }

    /**
     * Set selected_tutor
     *
     * @param \Rayku\ApiBundle\Entity\Tutor $selectedTutor
     * @return Session
     */
    public function setSelectedTutor(\Rayku\ApiBundle\Entity\Tutor $selectedTutor = null)
    {
        $this->selected_tutor = $selectedTutor;
    
        return $this;
    }

    /**
     * Get selected_tutor
     *
     * @return \Rayku\ApiBundle\Entity\Tutor 
     */
    public function getSelectedTutor()
    {
        return $this->selected_tutor;
    }
}