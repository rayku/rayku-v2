<?php

namespace Rayku\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TutorProfile
 *
 * @ORM\Table(name="tutor_profile")
 * @ORM\Entity
 */
class TutorProfile
{
    /**
     * @var integer
     *
     * @ORM\Column(name="tutor_profile_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $tutorProfileId;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     */
    private $userId;

    /**
     * @var integer
     *
     * @ORM\Column(name="category", type="integer", nullable=false)
     */
    private $category;

    /**
     * @var string
     *
     * @ORM\Column(name="course_id", type="string", length=200, nullable=false)
     */
    private $courseId;

    /**
     * @var string
     *
     * @ORM\Column(name="school", type="string", length=300, nullable=false)
     */
    private $school;

    /**
     * @var string
     *
     * @ORM\Column(name="year", type="string", length=100, nullable=false)
     */
    private $year;

    /**
     * @var string
     *
     * @ORM\Column(name="tutor_role", type="string", length=300, nullable=false)
     */
    private $tutorRole;

    /**
     * @var string
     *
     * @ORM\Column(name="study", type="string", length=300, nullable=false)
     */
    private $study;

    /**
     * @var string
     *
     * @ORM\Column(name="course_code", type="string", length=300, nullable=false)
     */
    private $courseCode;



    /**
     * Get tutorProfileId
     *
     * @return integer 
     */
    public function getTutorProfileId()
    {
        return $this->tutorProfileId;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     * @return TutorProfile
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    
        return $this;
    }

    /**
     * Get userId
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set category
     *
     * @param integer $category
     * @return TutorProfile
     */
    public function setCategory($category)
    {
        $this->category = $category;
    
        return $this;
    }

    /**
     * Get category
     *
     * @return integer 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set courseId
     *
     * @param string $courseId
     * @return TutorProfile
     */
    public function setCourseId($courseId)
    {
        $this->courseId = $courseId;
    
        return $this;
    }

    /**
     * Get courseId
     *
     * @return string 
     */
    public function getCourseId()
    {
        return $this->courseId;
    }

    /**
     * Set school
     *
     * @param string $school
     * @return TutorProfile
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
     * Set year
     *
     * @param string $year
     * @return TutorProfile
     */
    public function setYear($year)
    {
        $this->year = $year;
    
        return $this;
    }

    /**
     * Get year
     *
     * @return string 
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set tutorRole
     *
     * @param string $tutorRole
     * @return TutorProfile
     */
    public function setTutorRole($tutorRole)
    {
        $this->tutorRole = $tutorRole;
    
        return $this;
    }

    /**
     * Get tutorRole
     *
     * @return string 
     */
    public function getTutorRole()
    {
        return $this->tutorRole;
    }

    /**
     * Set study
     *
     * @param string $study
     * @return TutorProfile
     */
    public function setStudy($study)
    {
        $this->study = $study;
    
        return $this;
    }

    /**
     * Get study
     *
     * @return string 
     */
    public function getStudy()
    {
        return $this->study;
    }

    /**
     * Set courseCode
     *
     * @param string $courseCode
     * @return TutorProfile
     */
    public function setCourseCode($courseCode)
    {
        $this->courseCode = $courseCode;
    
        return $this;
    }

    /**
     * Get courseCode
     *
     * @return string 
     */
    public function getCourseCode()
    {
        return $this->courseCode;
    }
}