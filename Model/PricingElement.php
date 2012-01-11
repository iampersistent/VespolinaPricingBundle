<?php
/**
 * (c) Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\PricingBundle\Model;

use Vespolina\PricingBundle\Model\PricingElementInterface;
/**
 * PricingElement is the basic entity needed to determine prices
 * An example of pricing element is 'net_value' of 'sales_tax_percentage'
 *
 * @author Daniel Kucharski <daniel@xerias.be>
 */
class PricingElement implements PricingElementInterface
{
    protected $isDetermined;
    protected $name;
    protected $value;

    function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @inheritdoc
     */
    public function getIsDetermined()
    {

        return $this->isDetermined;
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {

        return $this->name;
    }

    /**
     * @inheritdoc
     */
    public function getValue()
    {

        return $this->value;
    }

    /**
     * @inheritdoc
     */
    public function setIsDetermined($isDetermined)
    {

        return $this->isDetermined = $isDetermined;
    }
    
    /**
     * @inheritdoc
     */
    public function setValue($value)
    {
        $this->value = $value;
    }
}