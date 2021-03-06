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
     * @Route("")
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
     * Update a Topic
     *
     * @ApiDoc(
     *  input="Chat\ApplicationBundle\Entity\Topic",
     *  output="Chat\ApplicationBundle\Entity\Topic",
     *  statusCodes={
     *      200="Updated",
     *      400="Validation errors"
     *  }
     * )
     *
     * @Route("/{id}", requirements={"id" = "\d+"})
     *
     * @ParamConverter("topic", name="newTopic", converter="fos_rest.request_body")
     * @ParamConverter("json_to_param")
     * @ParamConverter("topic", class="ChatApplicationBundle:Topic", options={"id" = "id"})
     *
     * @Method("PUT")
     * @Rest\View(statusCode=200)
     */
    public function updateAction(
        Topic $newTopic,
        Topic $topic,
        ConstraintViolationListInterface $validationErrors
    )
    {
        // Handle validation errors
        if (count($validationErrors) > 0) {
            return RestView::create(
                ['errors' => $validationErrors],
                Response::HTTP_BAD_REQUEST
            );
        }
        $topic->setTitle($newTopic->getTitle());
        $topic->setDescription($newTopic->getDescription());

        return $this->topicService->save($topic);
    }

    /**
     * Return a collection of Topics
     *
     * @ApiDoc(
     * resource=true,
     *  statusCodes={200="OK"}
     * )
     *
     * @Route("")
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
     * @ParamConverter("topic", class="ChatApplicationBundle:Topic", options={"id" = "id"})
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

    /**
     * Remove a Topic
     *
     * @ApiDoc(
     *  statusCodes={
     *      204="OK",
     *      404="Topic not found"
     *  }
     * )
     *
     * @Route("/{id}", requirements={"id" = "\d+"})
     * @ParamConverter("topic", class="ChatApplicationBundle:Topic", options={"id" = "id"})
     * @Method("DELETE")
     * @Rest\View(statusCode=204)
     */
    public function removeAction(Topic $topic)
    {
        $this->topicService->remove($topic);

        return [];
    }

    /**
     * Return a collection of Messages for a single Topic by the given id
     *
     * @ApiDoc(
     *  statusCodes={
     *      200="OK",
     *      404="Topic not found"
     *  }
     * )
     *
     * @Route("/{id}/messages", requirements={"id" = "\d+"})
     * @ParamConverter("topic", class="ChatApplicationBundle:Topic", options={"id" = "id"})
     * @Method("GET")
     * @Rest\View(serializerGroups={"minimal"})
     */
    public function getMessageCollectionAction(Topic $topic = null)
    {
        if (!$topic) {
            throw new NotFoundHttpException('Topic not found.');
        }

        return $topic->getMessages();
    }
    
    
    
}
