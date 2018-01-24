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

namespace TemplateBundle\Command;

use Sensio\Bundle\GeneratorBundle\Command\GenerateDoctrineCrudCommand;
use Sensio\Bundle\GeneratorBundle\Generator\DoctrineCrudGenerator;
use Sensio\Bundle\GeneratorBundle\Generator\DoctrineFormGenerator;
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
