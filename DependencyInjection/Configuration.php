<?php

/**
 * Baskel.
 *
 * @category   Baskel platform manager
 *
 * @author     Ali Ben Macha       <contact@benmacha.tn>
 */

namespace Benmacha\TemplateBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('benmacha_template');

        $rootNode
            ->children()
            ->scalarNode('site_name')->defaultValue('Macha Template')->end()
            ->end();

        return $treeBuilder;
    }

    /*
    public function process(ContainerBuilder $container)
    {

        $foo = $container->getParameter('macha_template.site_name');

        $def = $container->getDefinition('twig');
        $def->addMethodCall('addGlobal', array('macha_site_name', "eeeeeeee"));
    }

    public function load(array $configs, ContainerBuilder $container)
    {
        die;
        // TODO: Implement load() method.
    }*/
}
