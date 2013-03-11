<?php

namespace Rayku\StaticBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserFb
 *
 * @ORM\Table(name="user_fb")
 * @ORM\Entity
 */
class UserFb
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
     * @ORM\Column(name="fb_username", type="string", length=255, nullable=false)
     */
    private $fbUsername;

    /**
     * @var string
     *
     * @ORM\Column(name="fb_uid", type="string", length=100, nullable=false)
     */
    private $fbUid;



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
     * Set fbUsername
     *
     * @param string $fbUsername
     * @return UserFb
     */
    public function setFbUsername($fbUsername)
    {
        $this->fbUsername = $fbUsername;
    
        return $this;
    }

    /**
     * Get fbUsername
     *
     * @return string 
     */
    public function getFbUsername()
    {
        return $this->fbUsername;
    }

    /**
     * Set fbUid
     *
     * @param string $fbUid
     * @return UserFb
     */
    public function setFbUid($fbUid)
    {
        $this->fbUid = $fbUid;
    
        return $this;
    }

    /**
     * Get fbUid
     *
     * @return string 
     */
    public function getFbUid()
    {
        return $this->fbUid;
    }
}