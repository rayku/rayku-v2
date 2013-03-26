<?php

namespace Rayku\TutorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Tutor
 *
 * @ORM\Table(name="rayku_tutor",uniqueConstraints={@ORM\UniqueConstraint(name="user_idx", columns={"user_id"})})
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
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
     * @var \DateTime
     * 
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * @var \User
     *
     * @ORM\OneToOne(targetEntity="\Rayku\UserBundle\Entity\User", cascade={"persist"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;
    
    /**
     * @ORM\ManyToMany(targetEntity="\Rayku\TutorBundle\Entity\Subject")
     * @ORM\JoinTable(name="rayku_subject_tutor",
     *     joinColumns={@ORM\JoinColumn(name="tutor_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="subject_id", referencedColumnName="id")}
     * )
     */
    private $subjects;

    public function __toString()
    {
    	return $this->getUser()->__toString();
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
     * Get deletedAt
     * 
     * @return \DateTime
     */
    public function getDeletedAt()
    {
    	return $this->deletedAt;
    }
    
    /**
     * Set deletedAt
     * 
     * @param \DateTime $deletedAt
     * @return Tutor
     */
    public function setDeletedAt($deletedAt)
    {
    	$this->deletedAt = $deletedAt;
    	
    	return $this;
    }

    /**
     * Set user
     *
     * @param \Rayku\UserBundle\Entity\User $user
     * @return Tutor
     */
    public function setUser(\Rayku\UserBundle\Entity\User $user = null)
    {
    	$user->setTutor($this);
    	
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
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->subjects = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add subjects
     *
     * @param \Rayku\TutorBundle\Entity\Subject $subjects
     * @return Tutor
     */
    public function addSubject(\Rayku\TutorBundle\Entity\Subject $subjects)
    {
        $this->subjects[] = $subjects;
    
        return $this;
    }

    /**
     * Remove subjects
     *
     * @param \Rayku\TutorBundle\Entity\Subject $subjects
     */
    public function removeSubject(\Rayku\TutorBundle\Entity\Subject $subjects)
    {
        $this->subjects->removeElement($subjects);
    }

    /**
     * Get subjects
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSubjects()
    {
        return $this->subjects;
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