<?php

namespace Rayku\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use FOS\MessageBundle\Entity\Thread as BaseThread;
use FOS\MessageBundle\Model\ParticipantInterface;
use FOS\MessageBundle\Model\MessageInterface;
use FOS\MessageBundle\Model\ThreadMetadata as ModelThreadMetadata;

/**
 * @ORM\Entity
 * @ORM\Table(name="message_thread")
 */
class Thread extends BaseThread
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\generatedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\ManyToOne(targetEntity="Rayku\ApiBundle\Entity\User")
	 */
	protected $createdBy;

	/**
	 * @ORM\OneToMany(targetEntity="Rayku\ApiBundle\Entity\Message", mappedBy="thread")
	 */
	protected $messages;

	/**
	 * @ORM\OneToMany(targetEntity="Rayku\ApiBundle\Entity\ThreadMetadata", mappedBy="thread", cascade={"all"})
	 */
	protected $metadata;

	public function __construct()
	{
		parent::__construct();

		$this->messages = new ArrayCollection();
	}

	public function setCreatedBy(ParticipantInterface $participant) {
		$this->createdBy = $participant;
		return $this;
	}

	function addMessage(MessageInterface $message) {
		$this->messages->add($message);
	}

	public function addMetadata(ModelThreadMetadata $meta) {
		$meta->setThread($this);
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
     * Get createdBy
     *
     * @return \Rayku\ApiBundle\Entity\User 
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Remove messages
     *
     * @param \Rayku\ApiBundle\Entity\Message $messages
     */
    public function removeMessage(\Rayku\ApiBundle\Entity\Message $messages)
    {
        $this->messages->removeElement($messages);
    }

    /**
     * Get messages
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * Remove metadata
     *
     * @param \Rayku\ApiBundle\Entity\ThreadMetadata $metadata
     */
    public function removeMetadata(\Rayku\ApiBundle\Entity\ThreadMetadata $metadata)
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