<?php

/**
 * Lucky Stream panel.
 *
 * @category   IPTV
 *
 * @author     Ali Ben Macha       <contact@benmacha.tn>
 * @author     Azri Bilel          <azri.bilel@gmail.com>
 *
 * @see        http://dali.benmacha.tn/
 */

namespace Benmacha\TemplateBundle;

use Benmacha\TemplateBundle\DependencyInjection\Configuration;
use Benmacha\TemplateBundle\DependencyInjection\RegisterPropelModelsPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class TemplateBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new RegisterPropelModelsPass());
    }
}
