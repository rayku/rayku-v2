<?php

namespace Rayku\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Session
 *
 * @ORM\Entity(repositoryClass="Rayku\ApiBundle\Entity\SessionRepository")
 * @ORM\Table(name="rayku_session")
 * @Serializer\AccessorOrder("alphabetical")
 * @ORM\HasLifecycleCallbacks
 */
class Session
{
	const expire_session = '-20 minutes';
    /**
     * @var integer
     *
     * @Serializer\Groups({"session", "session.details"})
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @Serializer\Groups({"session", "session.details"})
     * @ORM\Column(name="start_time", type="datetime", nullable=true)
     * @Assert\DateTime()
     */
    private $startTime;

    /**
     * @var \DateTime
     *
     * @Serializer\Groups({"session", "session.details"})
     * @ORM\Column(name="end_time", type="datetime", nullable=true)
     * @Assert\DateTime()
     */
    private $endTime;

    /**
     * @var integer
     *
     * @Serializer\Groups({"session", "session.details"})
     * @ORM\Column(name="duration", type="integer", nullable=true)
     */
    private $duration;

    /**
     * @var integer
     *
     * @Serializer\Groups({"session", "session.details"})
     * @ORM\Column(name="rating", type="integer", nullable=true)
     */
    private $rating;

    /**
     * @var float
     *
     * @Serializer\Groups({"session", "session.details"})
     * @ORM\Column(name="rate", type="decimal", nullable=true)
     */
    private $rate;

    /**
     * @var string
     *
     * @Serializer\Groups({"session", "session.details"})
     * @ORM\Column(name="question", type="string", length=1000, nullable=true)
     */
    private $question = 'To be discussed';

    /**
     * @var integer
     *
     * @Serializer\Groups({"session", "session.details"})
     * @ORM\Column(name="recording_id", type="integer", nullable=true)
     */
    private $recordingId;

    /**
     * @var \User
     *
     * @Serializer\Groups({"session", "session.details"})
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
     * @Serializer\Exclude
     * @ORM\OneToMany(targetEntity="\Rayku\ApiBundle\Entity\SessionTutors", mappedBy="session", cascade={"persist", "remove"})
     */
    private $potential_tutors;
    
    /**
     * @var \Tutor
     *
     * @Serializer\Groups({"session", "session.details"})
     * @ORM\ManyToOne(targetEntity="\Rayku\ApiBundle\Entity\Tutor")
     * @ORM\JoinColumn(name="selected_tutor_id", referencedColumnName="id")
     */
    private $selectedTutor;
    
    /**
     * @var \DateTime
     *
     * @Serializer\Groups({"session", "session.details"})
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @ORM\ManyToMany(targetEntity="\Rayku\ApiBundle\Entity\Course", cascade={"persist"}, mappedBy="sessions")
     * @ORM\JoinTable(name="rayku_couse_session",
     *     joinColumns={@ORM\JoinColumn(name="session_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="course_id", referencedColumnName="id")}
     * )
     * @ORM\OrderBy({"createdAt" = "DESC"})
     * @Serializer\Groups({"session", "session.details"})
     */
    private $courses;
    
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private $updatedAt;

    /**
     * @var string
     *
     * @Serializer\Groups({"session", "session.details"})
     * @ORM\Column(name="student_session_name", type="string", length=1000, nullable=true)
     */
    private $student_session_name = 'No Name';

    /**
     * @var string
     *
     * @Serializer\Groups({"session", "session.details"})
     * @ORM\Column(name="tutor_session_name", type="string", length=1000, nullable=true)
     */
    private $tutor_session_name = 'No Name';
    
    public function __toString()
    {
    	return $this->getCreatedAt()->format('Y-m-d H:i:s');
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
    	
    	$minutes = 0;
    	$duration = 0;
    	$currentDate = new \DateTime(date('Y-m-d H:i:s'));
    	if(null !== $this->getStartTime()){
	    	$duration = $currentDate->diff($this->getStartTime());
	    	$minutes = $duration->days * 24 * 60;
	    	$minutes += $duration->h * 60;
	    	$minutes += $duration->i;
    	}
    	
    	$this->setDuration($minutes);
    	$this->setEndTime($currentDate);
    	$points = $minutes * $this->getRate();
    	
    	if(null !== $this->getSelectedTutor()){
	    	$this->getSelectedTutor()->getUser()->addPoints($points);
	    	$this->getStudent()->subtractPoints($points);
    	}
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
    	/*foreach($this->getPotentialTutors() as $potential_tutor)
    	{
    		if(in_array($potential_tutor->getTutorReply(), array('pending', 'contacted gtalk'))){
	    		$potential_tutor->getTutor()->setBusy(true);
    		}
    	}*/
    	
    	$tutor = $this->getSelectedTutor();
    	$student = ($this->getStudent()->getIsTutor()) ? $this->getStudent()->getTutor() : NULL;
    	if($this->getId() == null){ // New Session mark student as busy
    		if(!is_null($student)) $student->setBusy(true);
    	}else if($this->getStartTime() !== null && $this->getEndTime() === null){ // Active session with a start and no end
    		if(!is_null($student)) $student->setBusy(true);
    		if(!is_null($tutor)) $tutor->setBusy(true);
    	}else if($this->getEndTime() !== null){ // Session that has been ended
    		if(!is_null($student)) $student->setBusy(false);
    		if(!is_null($tutor)) $tutor->setBusy(false);
    	}
    	
    	return $this;
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
     * Set selectedTutor
     *
     * @param \Rayku\ApiBundle\Entity\Tutor $selectedTutor
     * @return Session
     */
    public function setSelectedTutor(\Rayku\ApiBundle\Entity\Tutor $selectedTutor = null)
    {
        $this->selectedTutor = $selectedTutor;
    
        return $this;
    }

    /**
     * Get selectedTutor
     *
     * @return \Rayku\ApiBundle\Entity\Tutor 
     */
    public function getSelectedTutor()
    {
        return $this->selectedTutor;
    }

    /**
     * Set student_session_name
     *
     * @param string $studentSessionName
     * @return Session
     */
    public function setStudentSessionName($studentSessionName)
    {
        $this->student_session_name = $studentSessionName;
    
        return $this;
    }

    /**
     * Get student_session_name
     *
     * @return string 
     */
    public function getStudentSessionName()
    {
        return $this->student_session_name;
    }

    /**
     * Set tutor_session_name
     *
     * @param string $tutorSessionName
     * @return Session
     */
    public function setTutorSessionName($tutorSessionName)
    {
        $this->tutor_session_name = $tutorSessionName;
    
        return $this;
    }

    /**
     * Get tutor_session_name
     *
     * @return string 
     */
    public function getTutorSessionName()
    {
        return $this->tutor_session_name;
    }

    /**
     * Add courses
     *
     * @param \Rayku\ApiBundle\Entity\Course $courses
     * @return Session
     */
    public function addCourse(\Rayku\ApiBundle\Entity\Course $courses)
    {
        $this->courses[] = $courses;
    
        return $this;
    }

    /**
     * Remove courses
     *
     * @param \Rayku\ApiBundle\Entity\Course $courses
     */
    public function removeCourse(\Rayku\ApiBundle\Entity\Course $courses)
    {
        $this->courses->removeElement($courses);
    }

    /**
     * Get courses
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCourses()
    {
        return $this->courses;
    }
}