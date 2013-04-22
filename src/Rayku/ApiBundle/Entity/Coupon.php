<?php

namespace Rayku\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Tutor
 *
 * @ORM\Table(name="rayku_coupon")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Coupon
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
     * @var string
     *
     * @Assert\NotBlank
     * @ORM\Column(name="coupon", type="string", length=255, nullable=false)
     */
    private $coupon = '';

    /**
     * @var integer
     *
     * @Assert\NotBlank
     * @ORM\Column(name="credit", type="integer", nullable=false)
     */
    private $credit = 0;
    
    /**
     * @var integer
     * 
     * @Assert\NotBlank
     * @ORM\Column(name="used", type="integer", nullable=false)
     */
    private $used = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="expiration_count", type="integer", nullable=true)
     */
    private $expirationCount;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="expiration_date", type="datetime", nullable=true)
     */
    private $expirationDate;

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

    public function __toString()
    {
    	return $this->getCoupon();
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
    
    public function incrementUsed()
    {
    	$used = $this->getUsed();
    	return $this->setUsed(++$used);
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
     * Set coupon
     *
     * @param string $coupon
     * @return Coupon
     */
    public function setCoupon($coupon)
    {
        $this->coupon = $coupon;
    
        return $this;
    }

    /**
     * Get coupon
     *
     * @return string 
     */
    public function getCoupon()
    {
        return $this->coupon;
    }

    /**
     * Set credit
     *
     * @param integer $credit
     * @return Coupon
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
     * Set expirationCount
     *
     * @param integer $expirationCount
     * @return Coupon
     */
    public function setExpirationCount($expirationCount)
    {
        $this->expirationCount = $expirationCount;
    
        return $this;
    }

    /**
     * Get expirationCount
     *
     * @return integer 
     */
    public function getExpirationCount()
    {
        return $this->expirationCount;
    }

    /**
     * Set expirationDate
     *
     * @param \DateTime $expirationDate
     * @return Coupon
     */
    public function setExpirationDate($expirationDate)
    {
        $this->expirationDate = $expirationDate;
    
        return $this;
    }

    /**
     * Get expirationDate
     *
     * @return \DateTime 
     */
    public function getExpirationDate()
    {
        return $this->expirationDate;
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
     * Set used
     *
     * @param integer $used
     * @return Coupon
     */
    public function setUsed($used)
    {
    	var_dump($used);
        $this->used = $used;
    
        return $this;
    }

    /**
     * Get used
     *
     * @return integer 
     */
    public function getUsed()
    {
        return $this->used;
    }
}