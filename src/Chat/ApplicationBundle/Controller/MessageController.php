<?php

namespace Chat\ApplicationBundle\Controller;

use Chat\ApplicationBundle\Entity\Message;
use Chat\ApplicationBundle\Entity\Topic;
use Chat\ApplicationBundle\Service\MessageService;
use Chat\ApplicationBundle\Service\TopicService;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View as RestView;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * Class MessageController
 *
 * @package Chat\ApplicationBundle\Controller
 *
 * @Route("/messages", service="chat_application.message.controller")
 */
class MessageController
{
    /**
     * @var \Chat\ApplicationBundle\Service\MessageService
     */
    private $messageService;

    /**
     * @var \Chat\ApplicationBundle\Service\TopicService
     */
    private $topicService;

    public function __construct(MessageService $messageService, TopicService $topicService)
    {
        $this->messageService = $messageService;
        $this->topicService = $topicService;
    }

    /**
     * Return a collection of Messages, optionally for a single Topic by the given id
     *
     * @ApiDoc(
     *  resource=true,
     *  statusCodes={
     *      200="OK",
     *      404="Message/Topic not found"
     *  }
     * )
     *
     * @Rest\QueryParam(
     *  name="topic_id",
     *  default=null,
     *  description="Filters response by topic."
     * )
     *
     * @Route("")
     * @Method("GET")
     * @Rest\View(serializerGroups={"minimal"})
     */
    public function getMessageCollectionAction(ParamFetcherInterface $paramFetcher)
    {
        $topicId = $paramFetcher->get('topic_id');

        if ($topicId) {
            $topic = $this->topicService->fetchById($topicId);

            if($topic) {
                return $topic->getMessages();
            }

            return [];
        }

        return $this->messageService->fetchAll();

    }

    /**
     * Return a single Message by the given id
     *
     * @ApiDoc(
     *  output={
     *      "class"="Chat\ApplicationBundle\Entity\Message"
     *  },
     *  statusCodes={
     *      200="OK",
     *      404="Message not found"
     *  }
     * )
     *
     * @Route("/{id}", requirements={"id" = "\d+"})
     * @ParamConverter("message", class="ChatApplicationBundle:Message", options={"id" = "id"})
     * @Method("GET")
     * @Rest\View()
     */
    public function getAction(Message $message)
    {
        return $message;
    }

    /**
     * Create a new Message
     *
     * @ApiDoc(
     *  input="Chat\ApplicationBundle\Entity\Message",
     *  output="Chat\ApplicationBundle\Entity\Message",
     *  statusCodes={
     *      201="Created",
     *      400="Validation errors"
     *  }
     * )
     *
     * @Route("")
     * @ParamConverter("json_to_param")
     * @ParamConverter("topic", name="topic", class="ChatApplicationBundle:Topic", options={"id" = "topic_id"})
     * @ParamConverter("message", converter="fos_rest.request_body")
     * @Method("POST")
     * @Rest\View(statusCode=201)
     */
    public function createAction(Message $message, Topic $topic, ConstraintViolationListInterface $validationErrors)
    {
        // Handle validation errors
        if (count($validationErrors) > 0 || !$topic instanceof Topic) {
            return RestView::create(
                ['errors' => $validationErrors],
                Response::HTTP_BAD_REQUEST
            );
        }
        $message->setTopic($topic);
        $message->setTime(new \DateTime());
        //var_dump($message);
        //\Doctrine\Common\Util\Debug::dump($message);
        return $this->messageService->save($message);
    }

    /**
     * Update a Message
     *
     * @ApiDoc(
     *  input="Chat\ApplicationBundle\Entity\Message",
     *  output="Chat\ApplicationBundle\Entity\Message",
     *  statusCodes={
     *      200="Updated",
     *      400="Validation errors"
     *  }
     * )
     *
     * @Route("/{id}", requirements={"id" = "\d+"})
     *
     * @ParamConverter("message", name="newMessage", converter="fos_rest.request_body")
     * @ParamConverter("json_to_param")
     * @ParamConverter("topic", name="topic", class="ChatApplicationBundle:Topic", options={"id" = "topic_id"})
     * @ParamConverter("message", class="ChatApplicationBundle:Message", options={"id" = "id"})
     *
     * @Method("PUT")
     * @Rest\View(statusCode=200)
     */
    public function updateAction(
                                 Message $message,
                                 Message $newMessage,
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
        $message->setTopic($topic);
        $message->setTime(new \DateTime());
        $message->setUser($newMessage->getUser());
        $message->setMessage($newMessage->getMessage());

        //var_dump($message);
        //\Doctrine\Common\Util\Debug::dump($message);
        return $this->messageService->save($message);
    }

    /**
     * Remove a Message
     *
     * @ApiDoc(
     *  statusCodes={
     *      204="OK",
     *      404="Message not found"
     *  }
     * )
     *
     * @Route("/{id}", requirements={"id" = "\d+"})
     * @ParamConverter("message", class="ChatApplicationBundle:Message", options={"id" = "id"})
     * @Method("DELETE")
     * @Rest\View(statusCode=204)
     */
    public function removeAction(Message $message)
    {
        $this->messageService->remove($message);

        return [];
    }
}
