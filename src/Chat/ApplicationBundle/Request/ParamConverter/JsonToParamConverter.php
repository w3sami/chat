<?php

namespace Chat\ApplicationBundle\Request\ParamConverter;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;

class JsonToParamConverter extends JsonAndQueryConverter implements ParamConverterInterface
{
    /**
     * {@inheritDoc}
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        parent::apply($request, $configuration);

        if(!empty($this->input['id'])) {
            $request->attributes->set('id', $this->input['id']);
        }
        
        foreach($this->input as $name => $value) {
            if(substr_count($name, '_id')) {
                $request->attributes->set($name, $this->input[$name]);

            }
            
            if(is_array($value) && !empty($value['id'])) {
                $request->attributes->set(substr($name, 1, 100) . '_id', $value['id']);
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function supports(ParamConverter $configuration)
    {
        return true;
    }
}
