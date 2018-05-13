<?php

/*
 * This file is part of the NelmioApiDocBundle.
 *
 * (c) Nelmio <hello@nelm.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BenMacha\TemplateBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('benmacha');

        $rootNode
            ->children()
            ->scalarNode('file')->defaultValue('')->end()
            ->scalarNode('alias')->defaultValue('')->end()
            ->scalarNode('app_id')->defaultValue('')->end()
            ->scalarNode('secret')->defaultValue('')->end()
            ->booleanNode('cookie')->defaultTrue()->end()
            ->arrayNode('permissions')
            ->canBeUnset()->prototype('scalar')->end()->end()
            ->end()
        ;

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
