<?php

namespace Rayku\UserBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity
 */
class User extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var float
     *
     * @ORM\Column(name="points", type="decimal", nullable=true)
     */
    protected $points;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    protected $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_activity_at", type="datetime", nullable=true)
     */
    protected $lastActivityAt;

    /**
     * @var integer
     *
     * @ORM\Column(name="type", type="integer", nullable=true)
     */
    protected $type;

    /**
     * @var integer
     *
     * @ORM\Column(name="hidden", type="integer", nullable=true)
     */
    protected $hidden;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=true)
     */
    protected $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="gender", type="integer", nullable=true)
     */
    protected $gender;

    /**
     * @var string
     *
     * @ORM\Column(name="hometown", type="string", length=100, nullable=true)
     */
    protected $hometown;

    /**
     * @var string
     *
     * @ORM\Column(name="home_phone", type="string", length=20, nullable=true)
     */
    protected $homePhone;

    /**
     * @var string
     *
     * @ORM\Column(name="mobile_phone", type="string", length=20, nullable=true)
     */
    protected $mobilePhone;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthdate", type="date", nullable=true)
     */
    protected $birthdate;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="text", nullable=true)
     */
    protected $address;

    /**
     * @var integer
     *
     * @ORM\Column(name="relationship_status", type="integer", nullable=true)
     */
    protected $relationshipStatus;

    /**
     * @var integer
     *
     * @ORM\Column(name="show_email", type="integer", nullable=true)
     */
    protected $showEmail;

    /**
     * @var integer
     *
     * @ORM\Column(name="show_gender", type="integer", nullable=true)
     */
    protected $showGender;

    /**
     * @var integer
     *
     * @ORM\Column(name="show_hometown", type="integer", nullable=true)
     */
    protected $showHometown;

    /**
     * @var integer
     *
     * @ORM\Column(name="show_home_phone", type="integer", nullable=true)
     */
    protected $showHomePhone;

    /**
     * @var integer
     *
     * @ORM\Column(name="show_mobile_phone", type="integer", nullable=true)
     */
    protected $showMobilePhone;

    /**
     * @var integer
     *
     * @ORM\Column(name="show_birthdate", type="integer", nullable=true)
     */
    protected $showBirthdate;

    /**
     * @var integer
     *
     * @ORM\Column(name="show_address", type="integer", nullable=true)
     */
    protected $showAddress;

    /**
     * @var integer
     *
     * @ORM\Column(name="show_relationship_status", type="integer", nullable=true)
     */
    protected $showRelationshipStatus;

    /**
     * @var string
     *
     * @ORM\Column(name="password_recover_key", type="string", length=40, nullable=true)
     */
    protected $passwordRecoverKey;

    /**
     * @var string
     *
     * @ORM\Column(name="cookie_key", type="string", length=40, nullable=true)
     */
    protected $cookieKey;

    /**
     * @var integer
     *
     * @ORM\Column(name="credit", type="integer", nullable=false)
     */
    protected $credit;

    /**
     * @var integer
     *
     * @ORM\Column(name="invisible", type="integer", nullable=false)
     */
    protected $invisible;

    /**
     * @var string
     *
     * @ORM\Column(name="notification", type="string", length=10, nullable=false)
     */
    protected $notification;

    /**
     * @var string
     *
     * @ORM\Column(name="phone_number", type="string", length=20, nullable=false)
     */
    protected $phoneNumber;

    /**
     * @var integer
     *
     * @ORM\Column(name="login", type="integer", nullable=false)
     */
    protected $login;

    /**
     * @var string
     *
     * @ORM\Column(name="credit_card", type="string", length=4, nullable=true)
     */
    protected $creditCard;

    /**
     * @var string
     *
     * @ORM\Column(name="credit_card_token", type="string", length=10, nullable=true)
     */
    protected $creditCardToken;

    /**
     * @var string
     *
     * @ORM\Column(name="braintree_customer_id", type="string", length=11, nullable=true)
     */
    protected $braintreeCustomerId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="first_charge", type="datetime", nullable=true)
     */
    protected $firstCharge;

    /**
     * @var string
     *
     * @ORM\Column(name="where_find_us", type="text", nullable=false)
     */
    protected $whereFindUs;

    /**
     * @var integer
     *
     * @ORM\Column(name="referred_by", type="integer", nullable=false)
     */
    protected $referredBy;

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
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;
    
        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;
    
        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set points
     *
     * @param float $points
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
     * @return float 
     */
    public function getPoints()
    {
        return $this->points;
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
     * Set lastActivityAt
     *
     * @param \DateTime $lastActivityAt
     * @return User
     */
    public function setLastActivityAt($lastActivityAt)
    {
        $this->lastActivityAt = $lastActivityAt;
    
        return $this;
    }

    /**
     * Get lastActivityAt
     *
     * @return \DateTime 
     */
    public function getLastActivityAt()
    {
        return $this->lastActivityAt;
    }

    /**
     * Set type
     *
     * @param integer $type
     * @return User
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set hidden
     *
     * @param integer $hidden
     * @return User
     */
    public function setHidden($hidden)
    {
        $this->hidden = $hidden;
    
        return $this;
    }

    /**
     * Get hidden
     *
     * @return integer 
     */
    public function getHidden()
    {
        return $this->hidden;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return User
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
     * Set gender
     *
     * @param integer $gender
     * @return User
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    
        return $this;
    }

    /**
     * Get gender
     *
     * @return integer 
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set hometown
     *
     * @param string $hometown
     * @return User
     */
    public function setHometown($hometown)
    {
        $this->hometown = $hometown;
    
        return $this;
    }

    /**
     * Get hometown
     *
     * @return string 
     */
    public function getHometown()
    {
        return $this->hometown;
    }

    /**
     * Set homePhone
     *
     * @param string $homePhone
     * @return User
     */
    public function setHomePhone($homePhone)
    {
        $this->homePhone = $homePhone;
    
        return $this;
    }

    /**
     * Get homePhone
     *
     * @return string 
     */
    public function getHomePhone()
    {
        return $this->homePhone;
    }

    /**
     * Set mobilePhone
     *
     * @param string $mobilePhone
     * @return User
     */
    public function setMobilePhone($mobilePhone)
    {
        $this->mobilePhone = $mobilePhone;
    
        return $this;
    }

    /**
     * Get mobilePhone
     *
     * @return string 
     */
    public function getMobilePhone()
    {
        return $this->mobilePhone;
    }

    /**
     * Set birthdate
     *
     * @param \DateTime $birthdate
     * @return User
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;
    
        return $this;
    }

    /**
     * Get birthdate
     *
     * @return \DateTime 
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return User
     */
    public function setAddress($address)
    {
        $this->address = $address;
    
        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set relationshipStatus
     *
     * @param integer $relationshipStatus
     * @return User
     */
    public function setRelationshipStatus($relationshipStatus)
    {
        $this->relationshipStatus = $relationshipStatus;
    
        return $this;
    }

    /**
     * Get relationshipStatus
     *
     * @return integer 
     */
    public function getRelationshipStatus()
    {
        return $this->relationshipStatus;
    }

    /**
     * Set showEmail
     *
     * @param integer $showEmail
     * @return User
     */
    public function setShowEmail($showEmail)
    {
        $this->showEmail = $showEmail;
    
        return $this;
    }

    /**
     * Get showEmail
     *
     * @return integer 
     */
    public function getShowEmail()
    {
        return $this->showEmail;
    }

    /**
     * Set showGender
     *
     * @param integer $showGender
     * @return User
     */
    public function setShowGender($showGender)
    {
        $this->showGender = $showGender;
    
        return $this;
    }

    /**
     * Get showGender
     *
     * @return integer 
     */
    public function getShowGender()
    {
        return $this->showGender;
    }

    /**
     * Set showHometown
     *
     * @param integer $showHometown
     * @return User
     */
    public function setShowHometown($showHometown)
    {
        $this->showHometown = $showHometown;
    
        return $this;
    }

    /**
     * Get showHometown
     *
     * @return integer 
     */
    public function getShowHometown()
    {
        return $this->showHometown;
    }

    /**
     * Set showHomePhone
     *
     * @param integer $showHomePhone
     * @return User
     */
    public function setShowHomePhone($showHomePhone)
    {
        $this->showHomePhone = $showHomePhone;
    
        return $this;
    }

    /**
     * Get showHomePhone
     *
     * @return integer 
     */
    public function getShowHomePhone()
    {
        return $this->showHomePhone;
    }

    /**
     * Set showMobilePhone
     *
     * @param integer $showMobilePhone
     * @return User
     */
    public function setShowMobilePhone($showMobilePhone)
    {
        $this->showMobilePhone = $showMobilePhone;
    
        return $this;
    }

    /**
     * Get showMobilePhone
     *
     * @return integer 
     */
    public function getShowMobilePhone()
    {
        return $this->showMobilePhone;
    }

    /**
     * Set showBirthdate
     *
     * @param integer $showBirthdate
     * @return User
     */
    public function setShowBirthdate($showBirthdate)
    {
        $this->showBirthdate = $showBirthdate;
    
        return $this;
    }

    /**
     * Get showBirthdate
     *
     * @return integer 
     */
    public function getShowBirthdate()
    {
        return $this->showBirthdate;
    }

    /**
     * Set showAddress
     *
     * @param integer $showAddress
     * @return User
     */
    public function setShowAddress($showAddress)
    {
        $this->showAddress = $showAddress;
    
        return $this;
    }

    /**
     * Get showAddress
     *
     * @return integer 
     */
    public function getShowAddress()
    {
        return $this->showAddress;
    }

    /**
     * Set showRelationshipStatus
     *
     * @param integer $showRelationshipStatus
     * @return User
     */
    public function setShowRelationshipStatus($showRelationshipStatus)
    {
        $this->showRelationshipStatus = $showRelationshipStatus;
    
        return $this;
    }

    /**
     * Get showRelationshipStatus
     *
     * @return integer 
     */
    public function getShowRelationshipStatus()
    {
        return $this->showRelationshipStatus;
    }

    /**
     * Set passwordRecoverKey
     *
     * @param string $passwordRecoverKey
     * @return User
     */
    public function setPasswordRecoverKey($passwordRecoverKey)
    {
        $this->passwordRecoverKey = $passwordRecoverKey;
    
        return $this;
    }

    /**
     * Get passwordRecoverKey
     *
     * @return string 
     */
    public function getPasswordRecoverKey()
    {
        return $this->passwordRecoverKey;
    }

    /**
     * Set cookieKey
     *
     * @param string $cookieKey
     * @return User
     */
    public function setCookieKey($cookieKey)
    {
        $this->cookieKey = $cookieKey;
    
        return $this;
    }

    /**
     * Get cookieKey
     *
     * @return string 
     */
    public function getCookieKey()
    {
        return $this->cookieKey;
    }

    /**
     * Set credit
     *
     * @param integer $credit
     * @return User
     */
    public function setCredit($credit)
    {
        $this->credit = $credit;
    
        return $this;
    }

    /**
     * Get credit
     *
     * @return integer 
     */
    public function getCredit()
    {
        return $this->credit;
    }

    /**
     * Set invisible
     *
     * @param integer $invisible
     * @return User
     */
    public function setInvisible($invisible)
    {
        $this->invisible = $invisible;
    
        return $this;
    }

    /**
     * Get invisible
     *
     * @return integer 
     */
    public function getInvisible()
    {
        return $this->invisible;
    }

    /**
     * Set notification
     *
     * @param string $notification
     * @return User
     */
    public function setNotification($notification)
    {
        $this->notification = $notification;
    
        return $this;
    }

    /**
     * Get notification
     *
     * @return string 
     */
    public function getNotification()
    {
        return $this->notification;
    }

    /**
     * Set phoneNumber
     *
     * @param string $phoneNumber
     * @return User
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    
        return $this;
    }

    /**
     * Get phoneNumber
     *
     * @return string 
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Set login
     *
     * @param integer $login
     * @return User
     */
    public function setLogin($login)
    {
        $this->login = $login;
    
        return $this;
    }

    /**
     * Get login
     *
     * @return integer 
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set creditCard
     *
     * @param string $creditCard
     * @return User
     */
    public function setCreditCard($creditCard)
    {
        $this->creditCard = $creditCard;
    
        return $this;
    }

    /**
     * Get creditCard
     *
     * @return string 
     */
    public function getCreditCard()
    {
        return $this->creditCard;
    }

    /**
     * Set creditCardToken
     *
     * @param string $creditCardToken
     * @return User
     */
    public function setCreditCardToken($creditCardToken)
    {
        $this->creditCardToken = $creditCardToken;
    
        return $this;
    }

    /**
     * Get creditCardToken
     *
     * @return string 
     */
    public function getCreditCardToken()
    {
        return $this->creditCardToken;
    }

    /**
     * Set braintreeCustomerId
     *
     * @param string $braintreeCustomerId
     * @return User
     */
    public function setBraintreeCustomerId($braintreeCustomerId)
    {
        $this->braintreeCustomerId = $braintreeCustomerId;
    
        return $this;
    }

    /**
     * Get braintreeCustomerId
     *
     * @return string 
     */
    public function getBraintreeCustomerId()
    {
        return $this->braintreeCustomerId;
    }

    /**
     * Set firstCharge
     *
     * @param \DateTime $firstCharge
     * @return User
     */
    public function setFirstCharge($firstCharge)
    {
        $this->firstCharge = $firstCharge;
    
        return $this;
    }

    /**
     * Get firstCharge
     *
     * @return \DateTime 
     */
    public function getFirstCharge()
    {
        return $this->firstCharge;
    }

    /**
     * Set whereFindUs
     *
     * @param string $whereFindUs
     * @return User
     */
    public function setWhereFindUs($whereFindUs)
    {
        $this->whereFindUs = $whereFindUs;
    
        return $this;
    }

    /**
     * Get whereFindUs
     *
     * @return string 
     */
    public function getWhereFindUs()
    {
        return $this->whereFindUs;
    }

    /**
     * Set referredBy
     *
     * @param integer $referredBy
     * @return User
     */
    public function setReferredBy($referredBy)
    {
        $this->referredBy = $referredBy;
    
        return $this;
    }

    /**
     * Get referredBy
     *
     * @return integer 
     */
    public function getReferredBy()
    {
        return $this->referredBy;
    }

    /**
     * Set usernameCanonical
     *
     * @param string $usernameCanonical
     * @return User
     */
    public function setUsernameCanonical($usernameCanonical)
    {
        $this->usernameCanonical = $usernameCanonical;
    
        return $this;
    }

    /**
     * Get usernameCanonical
     *
     * @return string 
     */
    public function getUsernameCanonical()
    {
        return $this->usernameCanonical;
    }

    /**
     * Set emailCanonical
     *
     * @param string $emailCanonical
     * @return User
     */
    public function setEmailCanonical($emailCanonical)
    {
        $this->emailCanonical = $emailCanonical;
    
        return $this;
    }

    /**
     * Get emailCanonical
     *
     * @return string 
     */
    public function getEmailCanonical()
    {
        return $this->emailCanonical;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return User
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    
        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean 
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    
        return $this;
    }

    /**
     * Get salt
     *
     * @return string 
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set locked
     *
     * @param boolean $locked
     * @return User
     */
    public function setLocked($locked)
    {
        $this->locked = $locked;
    
        return $this;
    }

    /**
     * Get locked
     *
     * @return boolean 
     */
    public function getLocked()
    {
        return $this->locked;
    }

    /**
     * Set expired
     *
     * @param boolean $expired
     * @return User
     */
    public function setExpired($expired)
    {
        $this->expired = $expired;
    
        return $this;
    }

    /**
     * Get expired
     *
     * @return boolean 
     */
    public function getExpired()
    {
        return $this->expired;
    }

    /**
     * Set confirmationToken
     *
     * @param string $confirmationToken
     * @return User
     */
    public function setConfirmationToken($confirmationToken)
    {
        $this->confirmationToken = $confirmationToken;
    
        return $this;
    }

    /**
     * Get confirmationToken
     *
     * @return string 
     */
    public function getConfirmationToken()
    {
        return $this->confirmationToken;
    }

    /**
     * Set credentialsExpired
     *
     * @param boolean $credentialsExpired
     * @return User
     */
    public function setCredentialsExpired($credentialsExpired)
    {
        $this->credentialsExpired = $credentialsExpired;
    
        return $this;
    }

    /**
     * Get credentialsExpired
     *
     * @return boolean 
     */
    public function getCredentialsExpired()
    {
        return $this->credentialsExpired;
    }
}