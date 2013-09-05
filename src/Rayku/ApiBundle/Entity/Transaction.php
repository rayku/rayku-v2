<?php

namespace Rayku\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Transaction
 *
 * @ORM\Table(name="rayku_transaction")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @Serializer\AccessorOrder("alphabetical")
 */
class Transaction
{
	const POINTS_COST = 0.01;
	
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
     * @ORM\ManyToOne(targetEntity="\Rayku\ApiBundle\Entity\User", inversedBy="transactions")
     * @Assert\Type(type="\Rayku\ApiBundle\Entity\User")
     */
    private $user;
    
	/**
     * @ORM\ManyToOne(targetEntity="\Rayku\ApiBundle\Entity\CreditCard", inversedBy="transactions")
     * @Assert\Type(type="\Rayku\ApiBundle\Entity\CreditCard")
	 **/
    private $card;

    /**
     * @var integer
     *
     * @ORM\Column(name="points", type="decimal", precision=10, scale=3, nullable=false)
     * @Assert\NotBlank()
     */
    private $points;

    /**
     * @var integer
     *
     * @ORM\Column(name="cost", type="decimal", precision=10, scale=3, nullable=false)
     * @Assert\NotBlank()
     */
    private $cost;
    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="string", columnDefinition="ENUM('pending', 'successful', 'failed')")
     * @Assert\NotBlank()
     */
    private $status = 'pending';
    
    /**
     * @var string
     *
     * @ORM\Column(name="transaction_reference", type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    private $reference;
    
    /**
     * @var string
     *
     * @ORM\Column(name="processor_data", type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    private $data;
    
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
     * Set cost
     *
     * @param integer $cost
     * @return Invoice
     */
    public function setCost($cost)
    {
        $this->cost = $cost;
        
        $this->setPoints($cost * self::POINTS_COST);
    
        return $this;
    }

    /**
     * Get cost
     *
     * @return integer 
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * Set points
     *
     * @param integer $points
     * @return Invoice
     */
    private function setPoints($points)
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
     * Set status
     *
     * @param string $status
     * @return Invoice
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

    /**
     * Set card
     *
     * @param \Rayku\ApiBundle\Entity\CreditCard $card
     * @return Transaction
     */
    public function setCard(\Rayku\ApiBundle\Entity\CreditCard $card = null)
    {
        $this->card = $card;
    
        return $this;
    }

    /**
     * Get card
     *
     * @return \Rayku\ApiBundle\Entity\CreditCard 
     */
    public function getCard()
    {
        return $this->card;
    }

    /**
     * Set reference
     *
     * @param string $reference
     * @return Transaction
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
     * @return Transaction
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
}