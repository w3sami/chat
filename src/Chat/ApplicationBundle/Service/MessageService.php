<?php

namespace Chat\ApplicationBundle\Service;


use Chat\ApplicationBundle\Entity\Message;
use Chat\ApplicationBundle\Entity\Repository\MessageRepository;

/**
 * Class MessageService
 *
 * @package Chat\ApplicationBundle\Service
 */
class MessageService
{
    /**
     * @var \Chat\ApplicationBundle\Entity\Repository\MessageRepository
     */
    private $messageRepository;

    /**
     * @param MessageRepository $messageRepository
     */
    public function __construct(MessageRepository $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }

    /**
     * Return all Message entities
     *
     * @return array Array of Feed entities
     */
    public function fetchAll()
    {
        return $this->messageRepository->findAll();
    }

    /**
     * Return one Message entity by the given id
     *
     * @param int $messageId
     *
     * @return null|Feed
     */
    private function fetchById($messageId)
    {
        return $this->messageRepository->find($messageId);
    }

    /**
     * @param Message $message
     *
     * @return Message The saved Message
     */
    public function save(Message $message)
    {
        $messageId = $this->messageRepository->save($message);

        return $this->fetchById($messageId);
    }

    /**
     * @param Message $message
     */
    public function remove(Message $message)
    {
        $this->messageRepository->remove($message);
    }
}
