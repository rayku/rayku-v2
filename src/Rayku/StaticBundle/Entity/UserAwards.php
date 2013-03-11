<?php

namespace Rayku\StaticBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserAwards
 *
 * @ORM\Table(name="user_awards")
 * @ORM\Entity
 */
class UserAwards
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
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=true)
     */
    private $userId;

    /**
     * @var integer
     *
     * @ORM\Column(name="awards", type="integer", nullable=true)
     */
    private $awards;



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
     * Set userId
     *
     * @param integer $userId
     * @return UserAwards
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    
        return $this;
    }

    /**
     * Get userId
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set awards
     *
     * @param integer $awards
     * @return UserAwards
     */
    public function setAwards($awards)
    {
        $this->awards = $awards;
    
        return $this;
    }

    /**
     * Get awards
     *
     * @return integer 
     */
    public function getAwards()
    {
        return $this->awards;
    }
}