<?php

namespace Chat\ApplicationBundle\Controller;

use Chat\ApplicationBundle\Entity\Topic;
use Chat\ApplicationBundle\Service\TopicService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View as RestView;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * Class TopicController
 *
 * @package Chat\ApplicationBundle\Controller
 *
 * @Route("/feeds/items", service="chat_application.topic.controller")
 */
class TopicController
{
    /**
     * @var \Chat\ApplicationBundle\Service\TopicService
     */
    private $topicService;

    public function __construct(TopicService $topicService)
    {
        $this->topicService = $topicService;
    }

    /**
     * Return a collection of Topics
     *
     * @ApiDoc(
     *  statusCodes={200="OK"}
     * )
     *
     * @Route("/")
     * @Method("GET")
     * @Rest\View()
     */
    public function getCollectionAction()
    {
        return $this->topicService->fetchAll();
    }



    /**
     * Return a single Topic by the given id
     *
     * @ApiDoc(
     *  resource=true,
     *  output={
     *      "class"="Chat\ApplicationBundle\Entity\Topic"
     *  },
     *  statusCodes={
     *      200="OK",
     *      404="Topic not found"
     *  }
     * )
     *
     * @Route("/{id}", requirements={"id" = "\d+"})
     * @ParamConverter("feed", class="ChatApplicationBundle:Topic")
     * @Method("GET")
     * @Rest\View()
     */
    public function getAction(Topic $topic = null)
    {
        if (!$topic) {
            throw new NotFoundHttpException('Feed item not found.');
        }

        return $topic;
    }
}
