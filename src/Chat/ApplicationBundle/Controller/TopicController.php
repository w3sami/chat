<?php

namespace Chat\ApplicationBundle\Controller;

use Chat\ApplicationBundle\Entity\Topic;
use Chat\ApplicationBundle\Service\TopicService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\ConstraintViolationListInterface;
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
 * @Route("/topics", service="chat_application.topic.controller")
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
     * Create a new Topic
     *
     * @ApiDoc(
     *  input="Chat\ApplicationBundle\Entity\Topic",
     *  output="Chat\ApplicationBundle\Entity\Topic",
     *  statusCodes={
     *      201="Created",
     *      400="Validation errors"
     *  }
     * )
     *
     * @Route("/")
     * @ParamConverter("topic", converter="fos_rest.request_body")
     * @Method("POST")
     * @Rest\View(statusCode=201)
     */
    public function createAction(Topic $topic, ConstraintViolationListInterface $validationErrors)
    {
        // Handle validation errors
        if (count($validationErrors) > 0) {
            return RestView::create(
                ['errors' => $validationErrors],
                Response::HTTP_BAD_REQUEST
            );
        }

        return $this->topicService->save($topic);
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
     * @ParamConverter("topic", class="ChatApplicationBundle:Topic")
     * @Method("GET")
     * @Rest\View()
     */
    public function getAction(Topic $topic = null)
    {
        if (!$topic) {
            throw new NotFoundHttpException('Topic not found.');
        }

        return $topic;
    }
}
