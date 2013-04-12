<?php

namespace Rayku\UserBundle\Entity;

use Symfony\Component\Validator\Constraints\True;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Entity\User as BaseUser;

/**
 * User
 *
 * @ORM\Table(name="fos_user_user",uniqueConstraints={@ORM\UniqueConstraint(name="tutor_idx", columns={"tutor_id"})})
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
	 * @var \User
	 *
	 * @ORM\OneToOne(targetEntity="\Rayku\TutorBundle\Entity\Tutor", cascade={"persist"})
	 * @ORM\JoinColumn(name="tutor_id", referencedColumnName="id")
	 */
	private $tutor;
	
	/**
	 * @var integer
	 * 
	 * @ORM\Column(name="points", type="integer", nullable=false)
	 */
	private $points = 0;
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="fname", type="string", length=255, nullable=false)
	 * @Assert\NotBlank()
	 */
	private $first_name = 'First Name';
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="lname", type="string", length=255, nullable=false)
	 * @Assert\NotBlank()
	 */
	private $last_name = 'Last Name';
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="school", type="string", length=255, nullable=false)
	 * @Assert\NotBlank()
	 */
	private $school = 'School';
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="school_year", type="string", length=255, nullable=false)
	 * @Assert\NotBlank()
	 */
	private $grade = 'Level of Education';
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="degree", type="string", length=255, nullable=false)
	 * @Assert\NotBlank()
	 */
	private $degree = 'Degree';
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="about", type="string", length=255, nullable=false)
	 * @Assert\NotBlank()
	 */
	private $bio = 'Short Bio';
	
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    
    public function addPoints($points)
    {
    	$this->setPoints($this->getPoints() + $points);
    	
    	return $this;
    }
    
    public function subtractPoints($points)
    {
    	$this->setPoints($this->getPoints() - $points);
    	 
    	return $this;
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
    
    /**
     * Get isTutor
     * 
     * @return boolean
     */
    public function getIsTutor()
    {
    	$deletedAt = NULL;
    	try{
    		$tutor = $this->getTutor();
    		if(!method_exists($tutor, 'getDeletedAt')){
    			return false;
    		}
    		$deletedAt = $this->getTutor()->getDeletedAt();
    	}catch(\Exception $e){
    		return false;
    	}
    	return ($deletedAt == null && null !== $this->getTutor()->getId()) ? true : false;
    }

    /**
     * Set points
     *
     * @param integer $points
     * @return User
     */
    public function setPoints($points)
    {
        $this->points = $points;
    
        return $this;
    }

    /**
     * Get points
     *
     * @return integer 
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * Set first_name
     *
     * @param string $firstName
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->first_name = $firstName;
    
        return $this;
    }

    /**
     * Get first_name
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * Set last_name
     *
     * @param string $lastName
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->last_name = $lastName;
    
        return $this;
    }

    /**
     * Get last_name
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * Set school
     *
     * @param string $school
     * @return User
     */
    public function setSchool($school)
    {
        $this->school = $school;
    
        return $this;
    }

    /**
     * Get school
     *
     * @return string 
     */
    public function getSchool()
    {
        return $this->school;
    }

    /**
     * Set grade
     *
     * @param string $grade
     * @return User
     */
    public function setGrade($grade)
    {
        $this->grade = $grade;
    
        return $this;
    }

    /**
     * Get grade
     *
     * @return string 
     */
    public function getGrade()
    {
        return $this->grade;
    }

    /**
     * Set degree
     *
     * @param string $degree
     * @return User
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
     * Set bio
     *
     * @param string $bio
     * @return User
     */
    public function setBio($bio)
    {
        $this->bio = $bio;
    
        return $this;
    }

    /**
     * Get bio
     *
     * @return string 
     */
    public function getBio()
    {
        return $this->bio;
    }
}