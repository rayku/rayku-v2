<?php

namespace Rayku\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Course
 *
 * @ORM\Table(name="rayku_credit_card")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @Serializer\AccessorOrder("alphabetical")
 */
class CreditCard
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
     * @var \User
     *
     * @ORM\OneToOne(targetEntity="\Rayku\ApiBundle\Entity\User", inversedBy="credit_card", cascade={"all"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @Serializer\Exclude
     */
    private $user;
    
    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", columnDefinition="ENUM('valid', 'invalid')")
     * @Assert\NotBlank()
     */
    private $status = 'valid';
    
    /**
     * @ORM\OneToMany(targetEntity="\Rayku\ApiBundle\Entity\Transaction", mappedBy="card")
     * @Serializer\Exclude
     **/
    private $transactions;
    
    /**
	 * @var string
	 *
	 * @ORM\Column(name="card_reference", type="string", length=255, nullable=false)
	 * @Serializer\Exclude
	 * @Assert\NotBlank()
     */
    private $reference;

    /**
     * @var string
     *
     * @ORM\Column(name="card_data", type="string", length=255, nullable=false)
     * @Serializer\Exclude
     * @Assert\NotBlank()
     */
    private $data;

    /**
     * @var string
     *
     * @ORM\Column(name="card_type", type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    private $type;
    
    /**
     * @var string
     *
     * @ORM\Column(name="card_digits", type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    private $digits;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="card_month", type="integer", nullable=false)
     * @Assert\NotBlank()
     */
    private $month;

    /**
     * @var integer
     *
     * @ORM\Column(name="card_year", type="integer", nullable=false)
     * @Assert\NotBlank()
     */
    private $year;
    
    /**
     * @var string
     *
     * @ORM\Column(name="card_name", type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    private $name;
    
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
     * Set reference
     *
     * @param string $reference
     * @return CreditCard
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
    
        return $this;
    }

    /**
     * Get reference
     *
     * @return string 
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set data
     *
     * @param string $data
     * @return CreditCard
     */
    public function setData($data)
    {
        $this->data = $data;
    
        return $this;
    }

    /**
     * Get data
     *
     * @return string 
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return CreditCard
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
     * Set digits
     *
     * @param string $digits
     * @return CreditCard
     */
    public function setDigits($digits)
    {
        $this->digits = $digits;
    
        return $this;
    }

    /**
     * Get digits
     *
     * @return string 
     */
    public function getDigits()
    {
        return $this->digits;
    }

    /**
     * Set month
     *
     * @param integer $month
     * @return CreditCard
     */
    public function setMonth($month)
    {
        $this->month = $month;
    
        return $this;
    }

    /**
     * Get month
     *
     * @return integer 
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * Set year
     *
     * @param integer $year
     * @return CreditCard
     */
    public function setYear($year)
    {
        $this->year = $year;
    
        return $this;
    }

    /**
     * Get year
     *
     * @return integer 
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return CreditCard
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
     * Set user
     *
     * @param \Rayku\ApiBundle\Entity\User $user
     * @return CreditCard
     */
    public function setUser(\Rayku\ApiBundle\Entity\User $user = null)
    {
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
        $this->transactions = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add transactions
     *
     * @param \Rayku\ApiBundle\Entity\Transaction $transactions
     * @return CreditCard
     */
    public function addTransaction(\Rayku\ApiBundle\Entity\Transaction $transactions)
    {
        $this->transactions[] = $transactions;
    
        return $this;
    }

    /**
     * Remove transactions
     *
     * @param \Rayku\ApiBundle\Entity\Transaction $transactions
     */
    public function removeTransaction(\Rayku\ApiBundle\Entity\Transaction $transactions)
    {
        $this->transactions->removeElement($transactions);
    }

    /**
     * Get transactions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTransactions()
    {
        return $this->transactions;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return CreditCard
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }
}