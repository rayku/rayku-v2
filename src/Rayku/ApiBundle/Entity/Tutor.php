<?php

namespace Rayku\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Tutor
 *
 * @ORM\Table(name="rayku_tutor",uniqueConstraints={@ORM\UniqueConstraint(name="user_idx", columns={"user_id"})})
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 * @Serializer\AccessorOrder("alphabetical")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Rayku\ApiBundle\Entity\TutorRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Tutor
{
	const expire_online = '-10 minutes';
	
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Serializer\Groups({"tutor", "tutor.details"})
     */
    private $id;

    /**
     * @var boolean
     *
     * @ORM\Column(name="direct_connect_only", type="boolean")
     * @Serializer\Groups({"tutor", "tutor.details"})
     */
    private $direct_connect = false;
    
    /**
     * @var string
     *
     * @ORM\Column(name="school_name", type="string", length=255, nullable=true)
     * @Serializer\Groups({"tutor", "tutor.details"})
     */
    private $schoolName;

    /**
     * @var string
     *
     * @ORM\Column(name="school_amount", type="string", length=255, nullable=true)
     * @Serializer\Groups({"tutor", "tutor.details"})
     */
    private $schoolAmount;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="degree", type="string", length=255, nullable=true)
     * @Serializer\Groups({"tutor", "tutor.details"})
     */
    private $degree;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="online_web", type="datetime", nullable=true)
     * @Serializer\Groups({"tutor", "tutor.details"})
     */
    private $onlineWeb;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="online_gtalk", type="datetime", nullable=true)
     * @Serializer\Groups({"tutor", "tutor.details"})
     */
    private $onlineGtalk;
    
    /**
     * @var string
     *
     * @Assert\Email
     * @ORM\Column(name="gtalk_email", type="string", length=255, nullable=true)
     */
    private $gtalk_email;

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
     * This field marks when a tutor was last "busy".
     * @Serializer\Groups({"tutor.details"})
     * @ORM\Column(name="busy", type="boolean", nullable=true)
     */
    private $busy = false;
    

    /**
     * @ORM\OneToMany(targetEntity="\Rayku\ApiBundle\Entity\Review", mappedBy="tutor")
     * @Serializer\Groups({"tutor.details"})
     **/
    private $reviews;
    
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
     * @ORM\OneToOne(targetEntity="\Rayku\ApiBundle\Entity\User", cascade={"persist"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @Serializer\Groups({"user"})
     */
    private $user;
    
    /**
     * @ORM\ManyToMany(targetEntity="\Rayku\ApiBundle\Entity\Subject")
     * @ORM\JoinTable(name="rayku_subject_tutor",
     *     joinColumns={@ORM\JoinColumn(name="tutor_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="subject_id", referencedColumnName="id")}
     * )
     * @Serializer\Groups({"tutor.details"})
     */
    private $subjects;
    
    public function __toString()
    {
    	$return = '';
    	try{
	    	$return = $this->getUser()->__toString();
    	}catch(\Exception $e){
    		return '';
    	}
    	
    	return $return;
    }
    
    public function getIsOnline()
    {
    	$lastOnline = $this->getOnlineWeb();
    	if($lastOnline instanceof \DateTime && $lastOnline->diff(new \DateTime(self::expire_online))->format('%i') > 0){
    		return true;
    	}
    	return false;
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
     * @param \Rayku\ApiBundle\Entity\User $user
     * @return Tutor
     */
    public function setUser(\Rayku\ApiBundle\Entity\User $user = null)
    {
    	$user->setTutor($this);
    	
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \Rayku\ApiBundle\Entity\User 
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
     * @param \Rayku\ApiBundle\Entity\Subject $subjects
     * @return Tutor
     */
    public function addSubject(\Rayku\ApiBundle\Entity\Subject $subjects)
    {
        $this->subjects[] = $subjects;
    
        return $this;
    }

    /**
     * Remove subjects
     *
     * @param \Rayku\ApiBundle\Entity\Subject $subjects
     */
    public function removeSubject(\Rayku\ApiBundle\Entity\Subject $subjects)
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

    /**
     * Set degree
     *
     * @param string $degree
     * @return Tutor
     */
    public function setDegree($degree)
    {
        $this->degree = $degree;
    
        return $this;
    }

    /**
     * Get degree
     *
     * @return string 
     */
    public function getDegree()
    {
        return $this->degree;
    }

    /**
     * Set onlineGtalk
     *
     * @param \DateTime $onlineGtalk
     * @return Tutor
     */
    public function setOnlineGtalk($onlineGtalk)
    {
        $this->onlineGtalk = $onlineGtalk;
    
        return $this;
    }

    /**
     * Get onlineGtalk
     *
     * @return \DateTime 
     */
    public function getOnlineGtalk()
    {
        return $this->onlineGtalk;
    }

    /**
     * Set gtalk_email
     *
     * @param string $gtalkEmail
     * @return Tutor
     */
    public function setGtalkEmail($gtalkEmail)
    {
        $this->gtalk_email = $gtalkEmail;
    
        return $this;
    }

    /**
     * Get gtalk_email
     *
     * @return string 
     */
    public function getGtalkEmail()
    {
        return $this->gtalk_email;
    }
    
    /**
     * Set busy
     *
     * @param \DateTime $busy
     * @return Tutor
     */
    public function setBusy($busy)
    {
        $this->busy = $busy;
    
        return $this;
    }

    /**
     * Get busy
     *
     * @return \DateTime 
     */
    public function getBusy()
    {
        return $this->busy;
    }

    /**
     * Add reviews
     *
     * @param \Rayku\ApiBundle\Entity\Review $reviews
     * @return Tutor
     */
    public function addReview(\Rayku\ApiBundle\Entity\Review $reviews)
    {
        $this->reviews[] = $reviews;
    
        return $this;
    }

    /**
     * Remove reviews
     *
     * @param \Rayku\ApiBundle\Entity\Review $reviews
     */
    public function removeReview(\Rayku\ApiBundle\Entity\Review $reviews)
    {
        $this->reviews->removeElement($reviews);
    }

    /**
     * Get reviews
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getReviews()
    {
        return $this->reviews;
    }

    /**
     * Set direct_connect
     *
     * @param boolean $directConnect
     * @return Tutor
     */
    public function setDirectConnect($directConnect)
    {
        $this->direct_connect = $directConnect;
    
        return $this;
    }

    /**
     * Get direct_connect
     *
     * @return boolean 
     */
    public function getDirectConnect()
    {
        return $this->direct_connect;
    }
}