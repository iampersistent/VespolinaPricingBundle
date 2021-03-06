<?php
/**
 * (c) Vespolina Project http://www.vespolina-project.org
 *
 * (c) Daniel Kucharski <daniel@xerias.be>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\PricingBundle\Model;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Vespolina\PricingBundle\Model\PricingContextContainer;
use Vespolina\PricingBundle\Model\PricingDimensionInterface;
use Vespolina\PricingBundle\Model\PricingSet;
use Vespolina\PricingBundle\Model\PricingSetInterface;

class PricingSetConfiguration implements PricingSetConfigurationInterface
{
    protected $pricingDimensions;
    protected $pricingElementConfigurations;
    protected $pricingExecutionSteps;

    public function __construct()
    {
        $this->executionEvents = array('context_independent', 'context_dependent');
        $this->pricingDimensions = array();
        $this->pricingElementConfigurations = array();
        $this->pricingExecutionSteps = array();

        foreach ($this->executionEvents as $executionEvent)
        {
            $this->pricingElements[$executionEvent] = array();
            $this->pricingExecutionSteps[$executionEvent] = array();
        }
    }

    public function addPricingDimension(PricingDimensionInterface $pricingDimension)
    {
        $this->pricingDimensions[$pricingDimension->getName()] = $pricingDimension;
    }

    public function addPricingElementConfiguration(PricingElementConfigurationInterface $pricingElementConfiguration)
    {

        $executionEvent = $pricingElementConfiguration->getExecutionEvent();

        $this->pricingElementConfigurations[$executionEvent][] = $pricingElementConfiguration;
                
    }

    public function addPricingExecutionStep(PricingExecutionStepInterface $executionStep, $options = array())
    {
        if (array_key_exists('execution_event', $options) && $options['execution_event']) {
            $executionEvent = $options['execution_event'];
        } else {
            $executionEvent = $this->getExecutionEvents();
            $executionEvent = $executionEvent[0];
        }

        $this->pricingExecutionSteps[$executionEvent][] = $executionStep;
    }

    public function getExecutionEvents()
    {

        return $this->executionEvents;
    }

    public function getPricingDimensions()
    {

        return $this->pricingDimensions;
    }

    public function getPricingExecutionSteps($executionStep = 'all')
    {
        if ($executionStep == 'all') {
            $out = array();

            foreach ($this->executionEvents as $executionEvent) {
                $out = array_merge($out, $this->pricingExecutionSteps[$executionEvent]);
            }
            return $out;
        }
        return $this->pricingExecutionSteps[$executionStep];
    }

    public function getPricingElementConfigurations($executionStep = 'all')
    {

        if ($executionStep == 'all') {

            $out = array();

            foreach ($this->executionEvents as $executionEvent) {

                $out = array_merge($out, $this->pricingElementConfigurations[$executionEvent]);
            }

            return $out;
        }
        
        return $this->pricingElementConfigurations[$executionStep];
    }
}