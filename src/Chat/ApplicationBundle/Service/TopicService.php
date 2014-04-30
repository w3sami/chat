<?php

namespace Chat\ApplicationBundle\Service;


use Chat\ApplicationBundle\Entity\Feed;
use Chat\ApplicationBundle\Repository\FeedRepository;

/**
 * Class FeedService
 *
 * @package Chat\ApplicationBundle\Service
 */
class FeedService
{
    /**
     * @var \Chat\ApplicationBundle\Repository\FeedRepository
     */
    private $feedRepository;

    /**
     * @param FeedRepository $feedRepository
     */
    public function __construct(FeedRepository $feedRepository)
    {
        $this->feedRepository = $feedRepository;
    }

    /**
     * Return all Feed entities
     *
     * @return array Array of Feed entities
     */
    public function fetchAll()
    {
        return $this->feedRepository->findAll();
    }

    /**
     * Return one Feed entity by the given id
     *
     * @param int $feedId
     *
     * @return null|Feed
     */
    private function fetchById($feedId)
    {
        return $this->feedRepository->find($feedId);
    }

    /**
     * @param Feed $feed
     *
     * @return Feed The saved Feed
     */
    public function save(Feed $feed)
    {
        $feedId = $this->feedRepository->save($feed);

        return $this->fetchById($feedId);
    }

    /**
     * @param Feed $feed
     */
    public function remove(Feed $feed)
    {
        $this->feedRepository->remove($feed);
    }


}
