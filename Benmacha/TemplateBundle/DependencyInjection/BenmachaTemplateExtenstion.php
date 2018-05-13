<?php
/**
 * Created by PhpStorm.
 * User: developper
 * Date: 13/05/18
 * Time: 11:05
 */

namespace benmacha\TemplateBundle\DependencyInjection;


use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader;

class BenmachaTemplateExtenstion extends Extension
{

    /**
     * Loads a specific configuration.
     *
     * @param array            $configs
     * @param ContainerBuilder $container
     *
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container)
    {

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        // TODO: Implement load() method.
    }
}