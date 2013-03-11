<?php

namespace Rayku\StaticBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserExpert
 *
 * @ORM\Table(name="user_expert")
 * @ORM\Entity
 */
class UserExpert
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
     * @ORM\Column(name="user_id", type="integer", nullable=true)
     */
    private $userId;

    /**
     * @var integer
     *
     * @ORM\Column(name="checked_id", type="integer", nullable=false)
     */
    private $checkedId;

    /**
     * @var integer
     *
     * @ORM\Column(name="category_id", type="integer", nullable=true)
     */
    private $categoryId;

    /**
     * @var integer
     *
     * @ORM\Column(name="course_id", type="integer", nullable=true)
     */
    private $courseId;

    /**
     * @var string
     *
     * @ORM\Column(name="question", type="string", length=255, nullable=false)
     */
    private $question;

    /**
     * @var integer
     *
     * @ORM\Column(name="exe_order", type="integer", nullable=true)
     */
    private $exeOrder;

    /**
     * @var integer
     *
     * @ORM\Column(name="time", type="integer", nullable=false)
     */
    private $time;

    /**
     * @var string
     *
     * @ORM\Column(name="course_code", type="string", length=100, nullable=true)
     */
    private $courseCode;

    /**
     * @var string
     *
     * @ORM\Column(name="year", type="string", length=50, nullable=true)
     */
    private $year;

    /**
     * @var string
     *
     * @ORM\Column(name="school", type="string", length=75, nullable=false)
     */
    private $school;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer", nullable=false)
     */
    private $status;

    /**
     * @var integer
     *
     * @ORM\Column(name="close", type="integer", nullable=false)
     */
    private $close;

    /**
     * @var integer
     *
     * @ORM\Column(name="cron", type="integer", nullable=false)
     */
    private $cron;



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
     * @return UserExpert
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
     * Set checkedId
     *
     * @param integer $checkedId
     * @return UserExpert
     */
    public function setCheckedId($checkedId)
    {
        $this->checkedId = $checkedId;
    
        return $this;
    }

    /**
     * Get checkedId
     *
     * @return integer 
     */
    public function getCheckedId()
    {
        return $this->checkedId;
    }

    /**
     * Set categoryId
     *
     * @param integer $categoryId
     * @return UserExpert
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;
    
        return $this;
    }

    /**
     * Get categoryId
     *
     * @return integer 
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * Set courseId
     *
     * @param integer $courseId
     * @return UserExpert
     */
    public function setCourseId($courseId)
    {
        $this->courseId = $courseId;
    
        return $this;
    }

    /**
     * Get courseId
     *
     * @return integer 
     */
    public function getCourseId()
    {
        return $this->courseId;
    }

    /**
     * Set question
     *
     * @param string $question
     * @return UserExpert
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
     * Set exeOrder
     *
     * @param integer $exeOrder
     * @return UserExpert
     */
    public function setExeOrder($exeOrder)
    {
        $this->exeOrder = $exeOrder;
    
        return $this;
    }

    /**
     * Get exeOrder
     *
     * @return integer 
     */
    public function getExeOrder()
    {
        return $this->exeOrder;
    }

    /**
     * Set time
     *
     * @param integer $time
     * @return UserExpert
     */
    public function setTime($time)
    {
        $this->time = $time;
    
        return $this;
    }

    /**
     * Get time
     *
     * @return integer 
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set courseCode
     *
     * @param string $courseCode
     * @return UserExpert
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

    /**
     * Set year
     *
     * @param string $year
     * @return UserExpert
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
     * Set school
     *
     * @param string $school
     * @return UserExpert
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
     * Set status
     *
     * @param integer $status
     * @return UserExpert
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set close
     *
     * @param integer $close
     * @return UserExpert
     */
    public function setClose($close)
    {
        $this->close = $close;
    
        return $this;
    }

    /**
     * Get close
     *
     * @return integer 
     */
    public function getClose()
    {
        return $this->close;
    }

    /**
     * Set cron
     *
     * @param integer $cron
     * @return UserExpert
     */
    public function setCron($cron)
    {
        $this->cron = $cron;
    
        return $this;
    }

    /**
     * Get cron
     *
     * @return integer 
     */
    public function getCron()
    {
        return $this->cron;
    }
}