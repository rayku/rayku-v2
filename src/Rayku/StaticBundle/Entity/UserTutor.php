<?php

namespace Rayku\StaticBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserTutor
 *
 * @ORM\Table(name="user_tutor")
 * @ORM\Entity
 */
class UserTutor
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
     * Get userid
     *
     * @return integer 
     */
    public function getUserid()
    {
        return $this->userid;
    }
}