<?php

namespace Benmacha\TemplateBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Vich\UploaderBundle\Exception\MappingNotFoundException;

class RegisterPropelModelsPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $mappings = $container->getParameter('benmacha_template.site_name');

        dump($mappings);
    }
}
