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
        $processor = new Processor();
        $configuration = new Configuration();

        $config = $processor->processConfiguration($configuration, $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));

        if (!in_array(strtolower($config['db_driver']), array('mongodb', 'orm'))) {
            throw new \InvalidArgumentException(sprintf('Invalid db driver "%s".', $config['db_driver']));
        }
        $loader->load(sprintf('%s.xml', $config['db_driver']));

        if (isset($config['cart'])) {
            $this->configureCart($config['cart'], $container);
        }

        if (isset($config['cart_item'])) {
            $this->configureCartItem($config['cart_item'], $container);
        }
    }

    protected function configureCart(array $config, ContainerBuilder $container)
    {
        if (isset($config['class'])) {
            $container->setParameter('vespolina.cart.model.cart.class', $config['class']);
        }
    }
    public function getNamespace()
    {
        return 'http://www.vespolina-org/schema/dic/vespolina-pricing-v1';
    }
}
