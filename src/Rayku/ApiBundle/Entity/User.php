<?php

namespace Rayku\ApiBundle\Entity;

use Symfony\Component\Validator\Constraints\True;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use JMS\Serializer\Annotation as Serializer;

use Doctrine\ORM\Mapping as ORM;
use Sonata\UserBundle\Entity\BaseUser as BaseUser;

/**
 * User
 *
 * @ORM\Table(name="fos_user_user",uniqueConstraints={@ORM\UniqueConstraint(name="tutor_idx", columns={"tutor_id"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @Serializer\AccessorOrder("alphabetical")
 * @UniqueEntity(fields={"username"}, groups={"registration"}, message="This username has been taken")
 * @UniqueEntity(fields={"email"}, groups={"registration"}, message="This email address has already been registered")
 */
class User extends BaseUser
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @Serializer\Groups({"list", "user.view"})
	 */
	protected $id;
	
	/**
	 * @var \User
	 *
	 * @ORM\OneToOne(targetEntity="\Rayku\ApiBundle\Entity\Tutor", cascade={"persist"})
	 * @ORM\JoinColumn(name="tutor_id", referencedColumnName="id")
	 * @Serializer\Groups({"user.view"})
	 */
	private $tutor;
	
	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $image_path;
	
	/**
	 * @var integer
	 * @ORM\Column(name="points", type="integer", nullable=false)
	 */
	private $points = 500;
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="fname", type="string", length=255, nullable=false)
	 * @Assert\NotBlank(groups={"registration"})
	 * @Serializer\Groups({"list", "user.view"})
	 */
	private $first_name = 'First Name';
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="lname", type="string", length=255, nullable=false)
	 * @Assert\NotBlank(groups={"registration"})
	 * @Serializer\Groups({"list", "user.view"})
	 */
	private $last_name = 'Last Name';
	
	/**
	 * @var string
	 * 
	 * @ORM\Column(name="referral_code", type="string", length=255, nullable=true)
	 * @Serializer\Groups({"user.view"})
	 */
	private $referral_code;
	
	/**
	 * @var string
	 * 
	 * @ORM\Column(name="referral_ip_address", type="string", length=255, nullable=true)
	 */
	private $referral_ip_address;
	
	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="referral_date", type="datetime", nullable=true)
	 */
	protected $referral_date;
	
	/**
     * @ORM\ManyToOne(targetEntity="\Rayku\ApiBundle\Entity\User")
     * @ORM\JoinColumn(name="referral_referer", referencedColumnName="id", nullable=true)
	 */
	private $referral_referer;
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="signup_question", type="string", length=255, nullable=true)
	 * @Serializer\Groups({"user.view"})
	 */
	private $signup_question;
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="school", type="string", length=255, nullable=false)
	 * @Assert\NotBlank()
	 * @Serializer\Groups({"user.view"})
	 */
	private $school = 'School';
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="school_year", type="string", length=255, nullable=false)
	 * @Assert\NotBlank()
	 * @Serializer\Groups({"user.view"})
	 */
	private $grade = 'Level of Education';
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="degree", type="string", length=255, nullable=false)
	 * @Assert\NotBlank()
	 * @Serializer\Groups({"user.view"})
	 */
	private $degree = 'Degree';
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="about", type="string", length=255, nullable=false)
	 * @Assert\NotBlank()
	 * @Serializer\Groups({"user.view"})
	 */
	private $bio = 'Short Bio';
	
	/**
	 * @var \Coupon
	 *
	 * @ORM\ManyToOne(targetEntity="\Rayku\ApiBundle\Entity\Coupon")
	 * @ORM\JoinColumns({
	 *   @ORM\JoinColumn(nullable=true, name="coupon_id", referencedColumnName="id")
	 * })
	 * @Assert\Type(type="\Rayku\ApiBundle\Entity\Coupon")
	 */
	private $coupon;
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="auto_login", type="string", length=255, nullable=true)
	 */
	private $autoLogin;
	
	/**
	 * @var \DateTime
	 * 
	 * @ORM\Column(name="auto_login_expire", type="datetime", nullable=true)
	 */
	protected $autoLoginExpire;
	
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
     * @param \Rayku\ApiBundle\Entity\Tutor $tutor
     * @return User
     */
    public function setTutor(\Rayku\ApiBundle\Entity\Tutor $tutor = null)
    {
        $this->tutor = $tutor;
    
        return $this;
    }

    /**
     * Get tutor
     *
     * @return \Rayku\ApiBundle\Entity\Tutor 
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
        return ($this->last_name == 'Last Name') ? '' : $this->last_name;
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

    /**
     * Set coupon
     *
     * @param \Rayku\ApiBundle\Entity\Coupon $coupon
     * @return User
     */
    public function setCoupon(\Rayku\ApiBundle\Entity\Coupon $coupon = null)
    {
        $this->coupon = $coupon;
    
        return $this;
    }

    /**
     * Get coupon
     *
     * @return \Rayku\ApiBundle\Entity\Coupon 
     */
    public function getCoupon()
    {
        return $this->coupon;
    }
    
    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
    	$this
    		->registerWithCouponCode()
    		->initReferralCode();
    	
    	return parent::prePersist();
    }
    
    public function initReferralCode()
    {
    	$this->setReferralCode(base64_encode(uniqid('rayku', true)));
    	
    	return $this;
    }
    
    public function registerWithCouponCode()
    {
    	if(null === $this->getId() && null !== $this->getCoupon()){
    		$expirationCount = $this->getCoupon()->getExpirationCount();
    		$expirationDate = $this->getCoupon()->getExpirationDate();
    		
    		if(
    			(null !== $this->getCoupon()->getExpirationCount() && $this->getCoupon()->getExpirationCount() > $this->getCoupon()->getUsed()) || 
    			(!empty($expirationDate) && $expirationDate < new \DateTime(date('Y-m-d H:i:s')))
    		){
		    	$this->setPoints($this->getCoupon()->getCredit());
    			$this->setCoupon($this->getCoupon()->incrementUsed());
    		}
    	}
    	
    	return $this;
    }
    
    public function clearAutoLogin()
    {
    	$this->setAutoLogin(NULL);
    	$this->setAutoLoginExpire(NULL);
    }
    
    public function createAutoLogin()
    {
    	$this->setAutoLogin(uniqid($this->getId(),true));
    	$this->setAutoLoginExpire(new DateTime(strtotime('+10 minutes')));
    	
    	return $this;
    }

    /**
     * Set autoLogin
     *
     * @param string $autoLogin
     * @return User
     */
    public function setAutoLogin($autoLogin)
    {
        $this->autoLogin = $autoLogin;
    
        return $this;
    }

    /**
     * Get autoLogin
     *
     * @return string 
     */
    public function getAutoLogin()
    {
        return $this->autoLogin;
    }

    /**
     * Set autoLoginExpire
     *
     * @param \DateTime $autoLoginExpire
     * @return User
     */
    public function setAutoLoginExpire($autoLoginExpire)
    {
        $this->autoLoginExpire = $autoLoginExpire;
    
        return $this;
    }

    /**
     * Get autoLoginExpire
     *
     * @return \DateTime 
     */
    public function getAutoLoginExpire()
    {
        return $this->autoLoginExpire;
    }
    
    /**
     * Set referral_code
     *
     * @param string $referralCode
     * @return User
     */
    public function setReferralCode($referralCode)
    {
        $this->referral_code = $referralCode;
    
        return $this;
    }

    /**
     * Get referral_code
     *
     * @return string 
     */
    public function getReferralCode()
    {
        return $this->referral_code;
    }

    /**
     * Set referral_ip_address
     *
     * @param string $referralIpAddress
     * @return User
     */
    public function setReferralIpAddress($referralIpAddress)
    {
        $this->referral_ip_address = $referralIpAddress;
    
        return $this;
    }

    /**
     * Get referral_ip_address
     *
     * @return string 
     */
    public function getReferralIpAddress()
    {
        return $this->referral_ip_address;
    }

    /**
     * Set referral_referer
     *
     * @param string $referralReferer
     * @return User
     */
    public function setReferralReferer($referralReferer)
    {
        $this->referral_referer = $referralReferer;
    
        return $this;
    }

    /**
     * Get referral_referer
     *
     * @return string 
     */
    public function getReferralReferer()
    {
        return $this->referral_referer;
    }
    
    /**
     * Set referral_date
     *
     * @param \DateTime $referralDate
     * @return User
     */
    public function setReferralDate($referralDate)
    {
        $this->referral_date = $referralDate;
    
        return $this;
    }

    /**
     * Get referral_date
     *
     * @return \DateTime 
     */
    public function getReferralDate()
    {
        return $this->referral_date;
    }
    
    /**
     * Set signup_question
     *
     * @param string $signupQuestion
     * @return User
     */
    public function setSignupQuestion($signupQuestion)
    {
        $this->signup_question = $signupQuestion;
    
        return $this;
    }

    /**
     * Get signup_question
     *
     * @return string 
     */
    public function getSignupQuestion()
    {
        return $this->signup_question;
    }
    
    /**
     * Set image_path
     *
     * @param string $imagePath
     * @return User
     */
    public function setImagePath($imagePath)
    {
        $this->image_path = $imagePath;
    
        return $this;
    }

    /**
     * Get image_path
     *
     * @return string 
     */
    public function getImagePath()
    {
        return $this->image_path;
    }
}