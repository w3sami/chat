<?php
namespace Chat\ApplicationBundle\Entity;

use Doctrine\ORM\Mapping AS ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass="Chat\ApplicationBundle\Entity\Repository\MessageRepository")
 *
 * @Serializer\ExclusionPolicy("none")
 */
class Message
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Serializer\Groups({"minimal"})
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @Serializer\Groups({"minimal"})
     */
    private $message;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @Serializer\Groups({"minimal"})
     */
    private $time;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     *
     * @Serializer\Groups({"minimal"})
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Topic", inversedBy="Messages")
     * @ORM\JoinColumn(name="topic_id", referencedColumnName="id", nullable=false)
     */
    private $Topic;

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
     * Set message
     *
     * @param string $message
     * @return Message
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string 
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set time
     *
     * @param \DateTime $time
     * @return Message
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get time
     *
     * @return \DateTime 
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set user
     *
     * @param string $user
     * @return Message
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return string 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set Topic
     *
     * @param \Chat\ApplicationBundle\Entity\Topic $topic
     * @return Message
     */
    public function setTopic(\Chat\ApplicationBundle\Entity\Topic $topic)
    {
        $this->Topic = $topic;

        return $this;
    }

    /**
     * Get Topic
     *
     * @return \Chat\ApplicationBundle\Entity\Topic 
     */
    public function getTopic()
    {
        return $this->Topic;
    }
}
