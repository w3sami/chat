<?php

namespace Chat\ApplicationBundle\Service;


use Chat\ApplicationBundle\Entity\Feed;
use Chat\ApplicationBundle\Repository\FeedItemRepository;

/**
 * Class FeedItemService
 *
 * @package Chat\ApplicationBundle\Service
 */
class FeedItemService
{
    /**
     * @var \Chat\ApplicationBundle\Repository\FeedRepository
     */
    private $feedItemRepository;

    /**
     * @param FeedItemRepository $feedItemRepository
     */
    public function __construct(FeedItemRepository $feedItemRepository)
    {
        $this->feedItemRepository = $feedItemRepository;
    }

    /**
     * Return all FeedItem entities
     *
     * @return array Array of Feed entities
     */
    public function fetchAll()
    {
        return $this->feedItemRepository->findAll();
    }

    /**
     * Return one FeedItem entity by the given id
     *
     * @param int $feedItemId
     *
     * @return null|Feed
     */
    private function fetchById($feedItemId)
    {
        return $this->feedItemRepository->find($feedItemId);
    }
}
