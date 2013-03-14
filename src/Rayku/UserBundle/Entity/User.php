<?php
 
namespace Rayku\UserBundle\Entity;
 
use Doctrine\ORM\Mapping as ORM;
use Application\Sonata\UserBundle\Entity\User as BaseUser;
 
/**
 * User
 *
 * @ORM\Table(name="fos_user_user")
 * @ORM\Entity
 */
class User extends BaseUser
{
 
}