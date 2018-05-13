<?php
/**
 * Created by PhpStorm.
 * User: developper
 * Date: 13/05/18
 * Time: 11:05
 */

namespace Benmacha\TemplateBundle\DependencyInjection;


use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;


class BenmachaTemplateExtenstion extends Extension implements ExtensionInterface, CompilerPassInterface
{

    private $config;

    /**
     * {@inheritdoc}
     *
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $this->config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

    }

    public function getAlias()
    {
        return 'benmacha_template';
    }


    public function process(ContainerBuilder $container)
    {

        $def = $container->getDefinition('twig');
        $def->addMethodCall('addGlobal', array('macha_site_name', $this->config['site_name']));
    }
}