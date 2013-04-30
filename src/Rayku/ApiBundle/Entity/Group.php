<?php

namespace MyProject\MyBundle\Entity;

use FOS\UserBundle\Entity\Group as BaseGroup;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_group")
 */
class Group extends BaseGroup
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
     protected $id;
     
     /**
      * @ORM\ManyToMany(targetEntity="MyProject\MyBundle\Entity\Group")
      * @ORM\JoinTable(name="fos_user_user_group",
      *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
      *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}
      * )
      */
     protected $groups;
}