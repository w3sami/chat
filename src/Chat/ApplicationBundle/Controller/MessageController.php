<?php

namespace Chat\ApplicationBundle\Controller;

use Chat\ApplicationBundle\Entity\Message;
use Chat\ApplicationBundle\Service\MessageService;
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

    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }

    /**
     * Return a collection of Messages
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
        return $this->messageService->fetchAll();
    }

    /**
     * Return a single Message by the given id
     *
     * @ApiDoc(
     *  resource=true,
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
     * @ParamConverter("message", class="ChatApplicationBundle:Message")
     * @Method("GET")
     * @Rest\View()
     */
    public function getAction(Message $message = null)
    {
        if (!$message) {
            throw new NotFoundHttpException('Message not found.');
        }

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
     * @Route("/")
     * @ParamConverter("message", converter="fos_rest.request_body")
     * @Method("POST")
     * @Rest\View(statusCode=201)
     */
    public function createAction(Message $message, ConstraintViolationListInterface $validationErrors)
    {
        // Handle validation errors
        if (count($validationErrors) > 0) {
            return RestView::create(
                ['errors' => $validationErrors],
                Response::HTTP_BAD_REQUEST
            );
        }

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
     * @ParamConverter("message", class="ChatApplicationBundle:Message")
     * @Method("DELETE")
     * @Rest\View(statusCode=204)
     */
    public function removeAction(Message $message = null)
    {
        if (!$message) {
            throw new NotFoundHttpException('Message not found.');
        }

        $this->messageService->remove($message);

        return [];
    }

    /**
     * Return a collection of MessageItems for a single Message by the given id
     *
     * @ApiDoc(
     *  statusCodes={
     *      200="OK",
     *      404="Message not found"
     *  }
     * )
     *
     * @Route("/{id}/items", requirements={"id" = "\d+"})
     * @ParamConverter("message", class="ChatApplicationBundle:Message")
     * @Method("GET")
     * @Rest\View()
     */
    public function getItemCollectionAction(Message $message = null)
    {
        if (!$message) {
            throw new NotFoundHttpException('Message not found.');
        }

        return $message->getItems();
    }
}
