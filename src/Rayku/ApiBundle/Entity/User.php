<?php

namespace Rayku\ApiBundle\Entity;

use Symfony\Component\Validator\Constraints\True;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use FOS\MessageBundle\Model\ParticipantInterface;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Entity\User as BaseUser;

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
class User extends BaseUser implements ParticipantInterface
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @Serializer\Groups({"user", "user.details"})
	 */
	protected $id;
	
	/**
	 * @var \User
	 *
	 * @ORM\OneToOne(targetEntity="\Rayku\ApiBundle\Entity\Tutor", cascade={"persist"})
	 * @ORM\JoinColumn(name="tutor_id", referencedColumnName="id")
	 * @Serializer\Groups({"user.details"})
	 */
	private $tutor;
	
	/**
	 * @ORM\OneToMany(targetEntity="\Rayku\ApiBundle\Entity\Order", mappedBy="user")
	 **/
	private $orders;
	

	/**
	 * @ORM\OneToMany(targetEntity="\Rayku\ApiBundle\Entity\Favorite", mappedBy="sender")
	 * @Serializer\Groups({"user.details"})
	 **/
	private $favorites;
	
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
	 * @Serializer\Groups({"user", "user.details"})
	 */
	private $first_name = ' ';
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="lname", type="string", length=255, nullable=false)
	 * @Assert\NotBlank(groups={"registration"})
	 * @Serializer\Groups({"user", "user.details"})
	 */
	private $last_name = ' ';
	
	/**
	 * @var string
	 * 
	 * @ORM\Column(name="referral_code", type="string", length=255, nullable=true)
	 * @Serializer\Groups({"user.details"})
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
     * @Serializer\Groups({"user.details"})
	 */
	private $referral_referer;
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="signup_question", type="string", length=255, nullable=true)
	 * @Serializer\Groups({"user.details"})
	 */
	private $signup_question;
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="school", type="string", length=255, nullable=false)
	 * @Assert\NotBlank()
	 * @Serializer\Groups({"user.details"})
	 */
	private $school = 'School';
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="school_year", type="string", length=255, nullable=false)
	 * @Assert\NotBlank()
	 * @Serializer\Groups({"user.details"})
	 */
	private $grade = 'Level of Education';
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="degree", type="string", length=255, nullable=false)
	 * @Assert\NotBlank()
	 * @Serializer\Groups({"user.details"})
	 */
	private $degree = 'Degree';
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="about", type="string", length=255, nullable=false)
	 * @Assert\NotBlank()
	 * @Serializer\Groups({"user.details"})
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
	 * @Serializer\Groups({"user.details"})
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
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $path;
	
	/**
	 * @Assert\File(maxSize="6000000")
	 */
	private $file;
	
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
	 * @Serializer\Groups({"user", "user.details"})
	 */
	private $webPath;

	/**
	 * @Serializer\Groups({"user", "user.details"})
	 */
	private $isTutor;
	
    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
        // check if we have an old image path
        if (isset($this->path)) {
            // store the old name to delete after the update
            $this->temp = $this->path;
            $this->path = null;
        } else {
            $this->path = 'initial';
        }
    }
    
    /**
     * @ORM\PostLoad()
     */
    public function postLoad()
    {
    	if($this->last_name == 'Last Name'){
    		$this->last_name = '';
    	}
    	$this->setImageWebPath();
    }
    
    private function setImageWebPath()
    {
    	if(null !== $this->getPath()){
    		$this->webPath = '/'.$this->getUploadDir().'/'.$this->getPath();
    	}else{
    		$this->webPath = '/default_profile.jpg';
    	}
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
    	if (null !== $this->getFile()) {
    		// do whatever you want to generate a unique name
    		$filename = sha1(uniqid(mt_rand(), true));
    		$this->path = $filename.'.'.$this->getFile()->guessExtension();
    	}
    }
    
    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
    	if (null === $this->getFile()) {
    		return;
    	}
    
    	// if there is an error when moving the file, an exception will
    	// be automatically thrown by move(). This will properly prevent
    	// the entity from being persisted to the database on error
    	$this->getFile()->move($this->getUploadRootDir(), $this->path);
    
    	// check if we have an old image
    	if (isset($this->temp)) {
    		// delete the old image
    		unlink($this->getUploadRootDir().'/'.$this->temp);
    		// clear the temp image path
    		$this->temp = null;
    	}
    	$this->file = null;
    }
    
    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
    	if ($file = $this->getAbsolutePath()) {
    		unlink($file);
    	}
    }
    
	/**
	 * Get file.
	 *
	 * @return UploadedFile
	 */
	public function getFile()
	{
		return $this->file;
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
    			$this->isTutor = false;
    			return $this->isTutor;
    		}
    		$deletedAt = $this->getTutor()->getDeletedAt();
    	}catch(\Exception $e){
    		$this->isTutor = false;
    		return $this->isTutor;
    	}
    	$this->isTutor = ($deletedAt == null && null !== $this->getTutor()->getId()) ? true : false;
    	return $this->isTutor;
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
     * @ORM\PreUpdate()
     */
    public function preUpdate()
    {
    	$this->setUpdatedAt(new \DateTime);
    }
    
    /**
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
    	$this->setCreatedAt(new \DateTime);
    	$this->setUpdatedAt(new \DateTime);
    }
    
    /**
     * @ORM\PrePersist
     */
    public function initReferralCode()
    {
    	$this->setReferralCode(base64_encode(uniqid('rayku', true)));
    	
    	return $this;
    }
    
    /**
     * @ORM\PrePersist
     */
    public function registerWithCouponCode()
    {
    	if(null === $this->getId() && null !== $this->getCoupon()){
    		$expirationCount = $this->getCoupon()->getExpirationCount();
    		$expirationDate = $this->getCoupon()->getExpirationDate();
    		
    		if(
    			(null !== $this->getCoupon()->getExpirationCount() && $this->getCoupon()->getExpirationCount() > $this->getCoupon()->getUsed()) || 
    			(!empty($expirationDate) && $expirationDate > new \DateTime(date('Y-m-d H:i:s')))
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
    
    public function getAbsolutePath()
    {
    	return null === $this->getPath()
    		? null
    		: $this->getUploadRootDir().'/'.$this->getPath();
    }
    
    public function getWebPath()
    {
    	return $this->webPath;
    }
    
    protected function getUploadRootDir()
    {
    	// the absolute directory path where uploaded
    	// documents should be saved
    	return '/var/www/'.$this->getUploadDir();
    }
    
    protected function getUploadDir()
    {
    	// get rid of the __DIR__ so it doesn't screw up
    	// when displaying uploaded doc/image in the view.
    	return 'uploads/users';
    }

    /**
     * Set path
     *
     * @param string $path
     * @return User
     */
    public function setPath($path)
    {
        $this->path = $path;
    
        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return User
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
     * @return User
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
     * Constructor
     */
    public function __construct()
    {
        $this->orders = new \Doctrine\Common\Collections\ArrayCollection();
        $this->setImageWebPath();
        $this->getIsTutor();
        
        return parent::__construct();
    }
    
    /**
     * Add orders
     *
     * @param \Rayku\ApiBundle\Entity\Order $orders
     * @return User
     */
    public function addOrder(\Rayku\ApiBundle\Entity\Order $orders)
    {
        $this->orders[] = $orders;
    
        return $this;
    }

    /**
     * Remove orders
     *
     * @param \Rayku\ApiBundle\Entity\Order $orders
     */
    public function removeOrder(\Rayku\ApiBundle\Entity\Order $orders)
    {
        $this->orders->removeElement($orders);
    }

    /**
     * Get orders
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOrders()
    {
        return $this->orders;
    }

    /**
     * Add favorites
     *
     * @param \Rayku\ApiBundle\Entity\Favorite $favorites
     * @return User
     */
    public function addFavorite(\Rayku\ApiBundle\Entity\Favorite $favorites)
    {
        $this->favorites[] = $favorites;
    
        return $this;
    }

    /**
     * Remove favorites
     *
     * @param \Rayku\ApiBundle\Entity\Favorite $favorites
     */
    public function removeFavorite(\Rayku\ApiBundle\Entity\Favorite $favorites)
    {
        $this->favorites->removeElement($favorites);
    }

    /**
     * Get favorites
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFavorites()
    {
        return $this->favorites;
    }
}