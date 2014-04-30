<?php

namespace Chat\ApplicationBundle\Request\ParamConverter;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Chat\ApplicationBundle\Service\TopicService;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class SmartConverter extends JsonAndQueryConverter implements ParamConverterInterface
{
    /**
     * @var TopicService
     */
    protected $topicService;

    /**
     * @param $topicService
     */
    public function __construct(TopicService $topicService) {
        $this->topicService = $topicService;
    }

    /**
     * {@inheritDoc}
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        parent::apply($request, $configuration);

        $name = $configuration->getName();
        if(!empty($this->input['_' . $name]) && !empty($this->input['_' . $name]['id'])) {
            $id = $this->input['_' . $name]['id'];
        }

        if(!empty($this->input[$name . '_id'])) {
            $id = $this->input[$name . '_id'];
        }

        if(!isset($id)) {
            throw new BadRequestHttpException('missing topic id');
        }

        $input = $this->topicService->fetchById($id);
        if(!$input) {
            throw new BadRequestHttpException('topic [' . $this->input['_' . $name]['id'] . '] not found');
        }

        $request->attributes->set($configuration->getName(), $input);
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function supports(ParamConverter $configuration)
    {
        return true;
    }
}
