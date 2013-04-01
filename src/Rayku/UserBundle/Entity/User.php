<?php

namespace Rayku\UserBundle\Entity;

use Symfony\Component\Validator\Constraints\True;

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
	 * @ORM\JoinColumn(name="tutor_id", referencedColumnName="id", onDelete="SET NULL")
	 */
	private $tutor;
	
	/**
	 * @var integer
	 * 
	 * @ORM\Column(name="points", type="integer", nullable=false)
	 */
	private $points;
	
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
    		if(method_exists($tutor, 'getDeletedAt')){
	    		$deletedAt = $this->getTutor()->getDeletedAt();
    		}
    	}catch(\Exception $e){
    		return false;
    	}
    	return ($deletedAt == null) ? true : false;
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
}