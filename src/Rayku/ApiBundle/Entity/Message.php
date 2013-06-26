<?php

namespace Rayku\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use FOS\MessageBundle\Entity\Message as BaseMessage;
use FOS\MessageBundle\Model\ThreadInterface;
use FOS\MessageBundle\Model\ParticipantInterface;
use FOS\MessageBundle\Model\MessageMetadata as ModelMessageMetadata;

/**
 * @ORM\Entity
 * @ORM\Table(name="message")
 */
class Message extends BaseMessage
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Rayku\ApiBundle\Entity\Thread", inversedBy="messages")
     * @ORM\JoinColumn(name="thread_id", referencedColumnName="id")
     */
    protected $thread;

    /**
     * @ORM\ManyToOne(targetEntity="Rayku\ApiBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $sender;

    /**
     * @ORM\OneToMany(targetEntity="Rayku\ApiBundle\Entity\MessageMetadata", mappedBy="message", cascade={"all"})
     */
    protected $metadata;

    public function __construct()
    {
        parent::__construct();

        $this->metadata  = new ArrayCollection();
    }

    public function setThread(ThreadInterface $thread) {
            $this->thread = $thread;
            return $this;
    }

    public function setSender(ParticipantInterface $sender) {
            $this->sender = $sender;
            return $this;
    }

    public function addMetadata(ModelMessageMetadata $meta) {
        $meta->setMessage($this);
        parent::addMetadata($meta);
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
     * Get thread
     *
     * @return \Rayku\ApiBundle\Entity\Thread 
     */
    public function getThread()
    {
        return $this->thread;
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
     * Remove metadata
     *
     * @param \Rayku\ApiBundle\Entity\MessageMetadata $metadata
     */
    public function removeMetadata(\Rayku\ApiBundle\Entity\MessageMetadata $metadata)
    {
        $this->metadata->removeElement($metadata);
    }

    /**
     * Get metadata
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMetadata()
    {
        return $this->metadata;
    }
}