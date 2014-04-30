<?php
namespace Chat\ApplicationBundle\Entity;

use Doctrine\ORM\Mapping AS ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass="Chat\ApplicationBundle\Entity\Repository\TopicRepository")
 *
 * @Serializer\ExclusionPolicy("none")
 */
class Topic
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="Message", mappedBy="Topic")
     *
     * @serializer\Exclude
     */
    private $Messages;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->Messages = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set title
     *
     * @param string $title
     * @return Topic
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Topic
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Add Messages
     *
     * @param \Chat\ApplicationBundle\Entity\Message $messages
     * @return Topic
     */
    public function addMessage(\Chat\ApplicationBundle\Entity\Message $messages)
    {
        $this->Messages[] = $messages;

        return $this;
    }

    /**
     * Remove Messages
     *
     * @param \Chat\ApplicationBundle\Entity\Message $messages
     */
    public function removeMessage(\Chat\ApplicationBundle\Entity\Message $messages)
    {
        $this->Messages->removeElement($messages);
    }

    /**
     * Get Messages
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMessages()
    {
        return $this->Messages;
    }
}
