<?php

namespace Chat\ApplicationBundle\Request\ParamConverter;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Chat\ApplicationBundle\Service\TopicService;

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
        if(empty($this->input['_' . $name]) || empty($this->input['_' . $name]['id'])) {
            return false;
        }

        $input = $this->topicService->fetchById($this->input['_' . $name]['id']);

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
