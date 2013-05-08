<?php

namespace Rayku\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Tutor
 *
 * @ORM\Table(name="rayku_review")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Review
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
     * @ORM\Column(name="review", type="string", length=255, nullable=false)
     */
    private $review = '';
    
    /**
     * @var \Tutor
     *
     * @ORM\ManyToOne(targetEntity="\Rayku\ApiBundle\Entity\Tutor", inversedBy="reviews")
     * @ORM\JoinColumn(name="tutor_id", referencedColumnName="id")
     */
    private $tutor;

    /**
     * @var string
     *
     * @ORM\Column(name="reviewer_name", type="string", length=255, nullable=true)
     */
    private $reviewer;

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
    	return $this->id();
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
     * Set review
     *
     * @param string $review
     * @return Review
     */
    public function setReview($review)
    {
        $this->review = $review;
    
        return $this;
    }

    /**
     * Get review
     *
     * @return string 
     */
    public function getReview()
    {
        return $this->review;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Review
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
     * @return Review
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
     * Set tutor
     *
     * @param \Rayku\ApiBundle\Entity\Tutor $tutor
     * @return Review
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
     * Set reviewer
     *
     * @param integer $reviewer
     * @return Review
     */
    public function setReviewer($reviewer)
    {
        $this->reviewer = $reviewer;
    
        return $this;
    }

    /**
     * Get reviewer
     *
     * @return integer 
     */
    public function getReviewer()
    {
        return $this->reviewer;
    }
}