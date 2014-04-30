<?php

namespace Chat\ApplicationBundle\Request\ParamConverter;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;

class JsonAndQueryConverter implements ParamConverterInterface
{
    /**
     * {@inheritDoc}
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        $input = json_decode($request->getContent(), true);
        if ($input === null) {
            parse_str($request->getContent(), $input);
        }

        $request->attributes->set($configuration->getName(), $input);
        $this->input = $input;

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
