<?php

/**
 * PHP version 7.* & Symfony 3.4.
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.
 *
 * Baskel.
 *
 * @category   Baskel platform manager
 *
 * @author     Ali Ben Macha       <contact@benmacha.tn>
 * @copyright  Ⓒ 2018 Cubes.TN
 *
 * @see       http://www.cubes.tn
 */

namespace Benmacha\TemplateBundle\Command;

use Benmacha\TemplateBundle\Generator\DoctrineFormGenerator;
use Sensio\Bundle\GeneratorBundle\Command\GenerateDoctrineCrudCommand;
use Sensio\Bundle\GeneratorBundle\Generator\DoctrineCrudGenerator;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;

/**
 * Class GenerateAdminCommand.
 */
class GenerateAdminCommand extends GenerateDoctrineCrudCommand
{
    protected $generator;
    private $formGenerator;

    protected function configure()
    {
        parent::configure();
        $this->setName('benmacha:generate:crud');
        $this->setDescription('CRUD generator');
    }

    /**
     * @param BundleInterface|null $bundle
     *
     * @return DoctrineCrudGenerator
     * @throws \Twig_Error_Loader
     */
    protected function getGenerator(BundleInterface $bundle = null)
    {
        if (null === $this->generator) {
            $this->generator = new DoctrineCrudGenerator($this->getContainer()->get('filesystem'), $bundle->getPath().'/');
            $this->getContainer()->get('twig.loader')->addPath($bundle->getPath());
            $this->generator->setSkeletonDirs(__DIR__.'/../Resources/skeleton');
        }

        return $this->generator;
    }

    /**
     * @param null $bundle
     *
     * @return DoctrineFormGenerator
     */
    protected function getFormGenerator($bundle = null)
    {
        if (null === $this->formGenerator) {
            $this->formGenerator = new DoctrineFormGenerator($this->getContainer()->get('filesystem'));
            $this->formGenerator->setSkeletonDirs(__DIR__.'/../Resources/skeleton');
        }

        return $this->formGenerator;
    }
}
