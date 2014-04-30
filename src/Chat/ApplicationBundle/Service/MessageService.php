<?php

namespace Chat\ApplicationBundle\Service;


use Chat\ApplicationBundle\Entity\Feed;
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
}
