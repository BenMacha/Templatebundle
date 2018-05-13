<?php

/**
 * Baskel.
 *
 * @category   Baskel platform manager
 *
 * @author     Ali Ben Macha       <contact@benmacha.tn>
 */

namespace Benmacha\TemplateBundle;

use Benmacha\TemplateBundle\DependencyInjection\BenmachaTemplateExtenstion;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class BenmachaTemplateBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->registerExtension(new BenmachaTemplateExtenstion());
    }
}
