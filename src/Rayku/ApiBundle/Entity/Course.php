<?php

namespace Rayku\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Course
 *
 * @ORM\Table(name="rayku_course")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @Serializer\AccessorOrder("alphabetical")
 * @UniqueEntity(fields={"slug"}, message="This course unique identifier has already been taken.  Course slugs must be unique")
 */
class Course
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
     * @ORM\Column(name="slug", type="string", length=255, nullable=false)
     * @Serializer\Groups({"course", "course.details"})
     */
    private $slug = '';
    
    /**
     * @var string
     *
     * @Assert\NotBlank
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     * @Serializer\Groups({"course", "course.details"})
     */
    private $name = '';

    /**
     * @var string
     *
     * @Assert\NotBlank
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     * @Serializer\Groups({"course", "course.details"})
     */
    private $description = '';   
     
    /**
     * @var string
     * 
     * @Assert\NotBlank
     * @ORM\Column(name="type", type="string", length=255, nullable=false)
     */
    private $type = 'secret';
    
    /**
     * @var \User
     *
     * @ORM\OneToOne(targetEntity="\Rayku\ApiBundle\Entity\User", cascade={"persist"})
     * @ORM\JoinColumn(name="instructor_id", referencedColumnName="id")
     */
    private $instructor;
    
    /**
     * @ORM\ManyToMany(targetEntity="\Rayku\ApiBundle\Entity\User")
     * @ORM\JoinTable(name="rayku_couse_student",
     *     joinColumns={@ORM\JoinColumn(name="course_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="student_id", referencedColumnName="id")}
     * )
     */
    private $students;
    
    /**
     * @ORM\ManyToMany(targetEntity="\Rayku\ApiBundle\Entity\Session", cascade={"persist"}, inversedBy="courses")
     * @ORM\JoinTable(name="rayku_couse_session",
     *     joinColumns={@ORM\JoinColumn(name="course_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="session_id", referencedColumnName="id")}
     * )
     * @ORM\OrderBy({"createdAt" = "DESC"})
     * @Serializer\Groups({"course.details"})
     */
    private $sessions;
    
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

    public function __toString()
    {
    	return $this->getName();
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Coupon
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
     * @return Coupon
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
     * Set name
     *
     * @param string $name
     * @return Course
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Course
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set instructor
     *
     * @param \Rayku\ApiBundle\Entity\User $instructor
     * @return Course
     */
    public function setInstructor(\Rayku\ApiBundle\Entity\User $instructor = null)
    {
        $this->instructor = $instructor;
    
        return $this;
    }

    /**
     * Get instructor
     *
     * @return \Rayku\ApiBundle\Entity\User 
     */
    public function getInstructor()
    {
        return $this->instructor;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->students = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add students
     *
     * @param \Rayku\ApiBundle\Entity\User $students
     * @return Course
     */
    public function addStudent(\Rayku\ApiBundle\Entity\User $students)
    {
        $this->students[] = $students;
    
        return $this;
    }

    /**
     * Remove students
     *
     * @param \Rayku\ApiBundle\Entity\User $students
     */
    public function removeStudent(\Rayku\ApiBundle\Entity\User $students)
    {
        $this->students->removeElement($students);
    }

    /**
     * Get students
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getStudents()
    {
        return $this->students;
    }

    /**
     * Add sessions
     *
     * @param \Rayku\ApiBundle\Entity\Session $sessions
     * @return Course
     */
    public function addSession(\Rayku\ApiBundle\Entity\Session $sessions)
    {
        $this->sessions[] = $sessions;
    
        return $this;
    }

    /**
     * Remove sessions
     *
     * @param \Rayku\ApiBundle\Entity\Session $sessions
     */
    public function removeSession(\Rayku\ApiBundle\Entity\Session $sessions)
    {
        $this->sessions->removeElement($sessions);
    }

    /**
     * Get sessions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSessions()
    {
        return $this->sessions;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Course
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Course
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    
        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }
}