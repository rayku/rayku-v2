<?php

namespace Rayku\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use JMS\Payment\CoreBundle\Entity\PaymentInstruction;


/**
 * Order
 *
 * @ORM\Table(name="rayku_favorite")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Favorite
{
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 * @Serializer\Groups({"favorite", "favorite.details"})
	 */
	private $id;
    
    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="\Rayku\ApiBundle\Entity\User", inversedBy="favorites")
     * @ORM\JoinColumn(name="sender_id", referencedColumnName="id")
     * @Serializer\Groups({"favorite.details"})
     */
    private $sender;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="\Rayku\ApiBundle\Entity\User")
     * @ORM\JoinColumn(name="receiver_id", referencedColumnName="id")
     * @Serializer\Groups({"favorite.details"})
     */
    private $receiver;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     * @Serializer\Groups({"favorite", "favorite.details"})
     */
    private $createdAt;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     * @Serializer\Groups({"favorite", "favorite.details"})
     */
    private $updatedAt;
    
    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Order
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
     * @return Order
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
     * @return Order
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
     * Set sender
     *
     * @param \Rayku\ApiBundle\Entity\User $sender
     * @return Favorite
     */
    public function setSender(\Rayku\ApiBundle\Entity\User $sender = null)
    {
        $this->sender = $sender;
    
        return $this;
    }

    /**
     * Get sender
     *
     * @return \Rayku\ApiBundle\Entity\User 
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * Set receiver
     *
     * @param \Rayku\ApiBundle\Entity\User $receiver
     * @return Favorite
     */
    public function setReceiver(\Rayku\ApiBundle\Entity\User $receiver = null)
    {
        $this->receiver = $receiver;
    
        return $this;
    }

    /**
     * Get receiver
     *
     * @return \Rayku\ApiBundle\Entity\User 
     */
    public function getReceiver()
    {
        return $this->receiver;
    }
}