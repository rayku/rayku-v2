<?php

namespace Rayku\StaticBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserGtalk
 *
 * @ORM\Table(name="user_gtalk")
 * @ORM\Entity
 */
class UserGtalk
{
    /**
     * @var integer
     *
     * @ORM\Column(name="userid", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $userid;

    /**
     * @var string
     *
     * @ORM\Column(name="gtalkid", type="string", length=100, nullable=false)
     */
    private $gtalkid;



    /**
     * Get userid
     *
     * @return integer 
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * Set gtalkid
     *
     * @param string $gtalkid
     * @return UserGtalk
     */
    public function setGtalkid($gtalkid)
    {
        $this->gtalkid = $gtalkid;
    
        return $this;
    }

    /**
     * Get gtalkid
     *
     * @return string 
     */
    public function getGtalkid()
    {
        return $this->gtalkid;
    }
}