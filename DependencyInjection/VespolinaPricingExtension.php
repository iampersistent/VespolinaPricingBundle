<?php
/**
 * (c) Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\PricingBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;

/**
 * VespolinaPricingExtension loads the pricing bundle extension.
 *
 * @author Daniel Kucharski <daniel@xerias.be>
 */
class VespolinaPricingExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));

        foreach (array('service') as $basename) {
            $loader->load(sprintf('%s.xml', $basename));
        }
    }

    public function getNamespace()
    {
        return 'http://www.vespolina-org/schema/dic/vespolina-pricing-v1';
    }
}
