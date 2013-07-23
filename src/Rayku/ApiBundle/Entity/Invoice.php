<?php

namespace Rayku\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Rayku\ApiBundle\Entity\Points as PointTransfer;

/**
 * Invoice
 *
 * @ORM\Table(name="rayku_invoice")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @Serializer\AccessorOrder("alphabetical")
 */
class Invoice extends PointTransfer
{
	const POINTS_COST = 0.01;
    
    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="\Rayku\ApiBundle\Entity\User", inversedBy="invoices", cascade={"all"})
     * @Assert\Type(type="\Rayku\ApiBundle\Entity\User")
     */
    private $user;
    
    /**
     * @var decimal
     *
     * @ORM\Column(name="cost", type="decimal", precision=10, scale=3, nullable=false)
     * @Assert\NotBlank()
     */
    private $cost;

    /**
     * @var decimal
     *
     * @ORM\Column(name="points", type="decimal", precision=10, scale=3, nullable=false)
     * @Assert\NotBlank()
     */
    private $points;
    
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
    
    public function __construct()
    {
    	$this->setTransferred(0);
    }
    
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
        
        $this->setCreditUser($user);
    
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
     * @param float $cost
     * @return Invoice
     */
    public function setCost($cost)
    {
        $this->cost = $cost;
        
        $points = $cost / self::POINTS_COST;
        $this->setPoints($points);
        $this->setTransferred($points);
        
        return $this;
    }

    /**
     * Get cost
     *
     * @return float 
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * Set points
     *
     * @param float $points
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
     * @return float 
     */
    public function getPoints()
    {
        return $this->points;
    }
}