<?php

namespace Rayku\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserCourse
 *
 * @ORM\Table(name="user_course")
 * @ORM\Entity
 */
class UserCourse
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
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="course_subject", type="string", length=255, nullable=false)
     */
    private $courseSubject;

    /**
     * @var string
     *
     * @ORM\Column(name="course_name", type="string", length=255, nullable=false)
     */
    private $courseName;

    /**
     * @var string
     *
     * @ORM\Column(name="course_year", type="string", length=255, nullable=false)
     */
    private $courseYear;

    /**
     * @var string
     *
     * @ORM\Column(name="course_performance", type="string", length=255, nullable=false)
     */
    private $coursePerformance;



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
     * Set userId
     *
     * @param integer $userId
     * @return UserCourse
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
     * Set courseSubject
     *
     * @param string $courseSubject
     * @return UserCourse
     */
    public function setCourseSubject($courseSubject)
    {
        $this->courseSubject = $courseSubject;
    
        return $this;
    }

    /**
     * Get courseSubject
     *
     * @return string 
     */
    public function getCourseSubject()
    {
        return $this->courseSubject;
    }

    /**
     * Set courseName
     *
     * @param string $courseName
     * @return UserCourse
     */
    public function setCourseName($courseName)
    {
        $this->courseName = $courseName;
    
        return $this;
    }

    /**
     * Get courseName
     *
     * @return string 
     */
    public function getCourseName()
    {
        return $this->courseName;
    }

    /**
     * Set courseYear
     *
     * @param string $courseYear
     * @return UserCourse
     */
    public function setCourseYear($courseYear)
    {
        $this->courseYear = $courseYear;
    
        return $this;
    }

    /**
     * Get courseYear
     *
     * @return string 
     */
    public function getCourseYear()
    {
        return $this->courseYear;
    }

    /**
     * Set coursePerformance
     *
     * @param string $coursePerformance
     * @return UserCourse
     */
    public function setCoursePerformance($coursePerformance)
    {
        $this->coursePerformance = $coursePerformance;
    
        return $this;
    }

    /**
     * Get coursePerformance
     *
     * @return string 
     */
    public function getCoursePerformance()
    {
        return $this->coursePerformance;
    }
}