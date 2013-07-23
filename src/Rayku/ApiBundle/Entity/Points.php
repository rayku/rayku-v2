<?php

namespace Rayku\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use JMS\Serializer\Annotation\Groups;
use Rayku\ApiBundle\Entity\Session;
use Rayku\ApiBundle\Entity\Invoice;

/**
 * Points
 *
 * @ORM\Entity
 * @ORM\Table(name="rayku_points_transferred")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"invoice" = "Invoice", "session" = "Session"})
 * @Serializer\AccessorOrder("alphabetical")
 */
class Points
{
	
    /**
     * @var integer
     *
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @Groups({"session", "session.details"})
     */
    private $id;	
    
    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="\Rayku\ApiBundle\Entity\User", cascade={"all"})
     * @Assert\Type(type="\Rayku\ApiBundle\Entity\User")
     */
    private $credit_user;


    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="\Rayku\ApiBundle\Entity\User", cascade={"all"})
     */
    private $debit_user;
    
    /**
     * @var decimal
     *
     * @ORM\Column(name="transferred", type="decimal", precision=10, scale=3, nullable=false)
     * @Assert\NotBlank()
     */
    private $transferred;
    
    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", columnDefinition="ENUM('pending', 'successful', 'failed')")
     * @Assert\NotBlank()
     */
    private $status = 'pending';

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
     * Set credit_user
     *
     * @param \Rayku\ApiBundle\Entity\User $creditUser
     * @return Points
     */
    public function setCreditUser(\Rayku\ApiBundle\Entity\User $creditUser = null)
    {
        $this->credit_user = $creditUser;
    
        return $this;
    }

    /**
     * Get credit_user
     *
     * @return \Rayku\ApiBundle\Entity\User 
     */
    public function getCreditUser()
    {
        return $this->credit_user;
    }

    /**
     * Set debit_user
     *
     * @param \Rayku\ApiBundle\Entity\User $debitUser
     * @return Points
     */
    public function setDebitUser(\Rayku\ApiBundle\Entity\User $debitUser = null)
    {
        $this->debit_user = $debitUser;
    
        return $this;
    }

    /**
     * Get debit_user
     *
     * @return \Rayku\ApiBundle\Entity\User 
     */
    public function getDebitUser()
    {
        return $this->debit_user;
    }

    /**
     * Set transferred
     *
     * @param float $transferred
     * @return Points
     */
    public function setTransferred($transferred)
    {
        $this->transferred = $transferred;
        
        if($transferred > 0){
	        $this->getCreditUser()->addPoints($transferred);
	        
	        if(NULL !== $this->getDebitUser()){
	        	$this->getDebitUser()->subtractPoints($transferred);
	        }
        }
    
        return $this;
    }

    /**
     * Get transferred
     *
     * @return float 
     */
    public function getTransferred()
    {
        return $this->transferred;
    }

    /**
     * Set id
     *
     * @param integer $id
     * @return Points
     */
    public function setId($id)
    {
        $this->id = $id;
    
        return $this;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Points
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