<?php

namespace Chat\ApplicationBundle\Service;


use Chat\ApplicationBundle\Entity\Topic;
use Chat\ApplicationBundle\Entity\Repository\TopicRepository;

/**
 * Class TopicService
 *
 * @package Chat\ApplicationBundle\Service
 */
class TopicService
{
    /**
     * @var \Chat\ApplicationBundle\Entity\Repository\TopicRepository
     */
    private $topicRepository;

    /**
     * @param TopicRepository $topicRepository
     */
    public function __construct(TopicRepository $topicRepository)
    {
        $this->topicRepository = $topicRepository;
    }

    /**
     * Return all Topic entities
     *
     * @return array Array of Topic entities
     */
    public function fetchAll()
    {
        return $this->topicRepository->findAll();
    }

    /**
     * Return one Topic entity by the given id
     *
     * @param int $topicId
     *
     * @return null|Topic
     */
    private function fetchById($topicId)
    {
        return $this->topicRepository->find($topicId);
    }

    /**
     * @param Topic $topic
     *
     * @return Topic The saved Topic
     */
    public function save(Topic $topic)
    {
        $topicId = $this->topicRepository->save($topic);

        return $this->fetchById($topicId);
    }

    /**
     * @param Topic $topic
     */
    public function remove(Topic $topic)
    {
        $this->topicRepository->remove($topic);
    }


}
