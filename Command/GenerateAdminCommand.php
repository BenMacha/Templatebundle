<?php

/**
 * PHP version 7.* & Symfony 3.4.
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.
 *
 * BenMacha Template.
 *
 * @category   Symfony Template
 *
 * @author     Ali Ben Macha       <contact@benmacha.tn>
 * @copyright  Ⓒ 2018 Cubes.TN
 *
 * @see       http://www.cubes.tn
 */

namespace Benmacha\TemplateBundle\Command;

use Benmacha\TemplateBundle\Generator\DoctrineFormGenerator;
use Sensio\Bundle\GeneratorBundle\Command\AutoComplete\EntitiesAutoCompleter;
use Sensio\Bundle\GeneratorBundle\Command\GenerateDoctrineCrudCommand;
use Sensio\Bundle\GeneratorBundle\Generator\DoctrineCrudGenerator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;

/**
 * Class GenerateAdminCommand.
 */
class GenerateAdminCommand extends GenerateDoctrineCrudCommand
{
    const SKELETON_DIR = array(__DIR__.'/../Resources/skeleton');
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
     * @throws \Twig_Error_Loader
     *
     * @return DoctrineCrudGenerator
     */
    protected function getGenerator(BundleInterface $bundle = null)
    {
        if (null === $this->generator) {
            $this->generator = new DoctrineCrudGenerator($this->getContainer()->get('filesystem'), $bundle->getPath().'/');
            $this->getContainer()->get('twig.loader')->addPath($bundle->getPath());
            $this->generator->setSkeletonDirs(GenerateAdminCommand::SKELETON_DIR);
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
            $this->formGenerator->setSkeletonDirs(GenerateAdminCommand::SKELETON_DIR);
        }

        return $this->formGenerator;
    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $questionHelper = $this->getQuestionHelper();
        $questionHelper->writeSection($output, 'Welcome to the BenMacha Template Doctrine2 CRUD generator');

        // namespace
        $output->writeln(array(
            '',
            'This command helps you generate CRUD controllers and templates.',
            '',
            'First, give the name of the existing entity for which you want to generate a CRUD',
            '(use the shortcut notation like <comment>MachaBundle:Post</comment>)',
            '',
        ));

        if ($input->hasOption('entity') && $entityOption = $input->getOption('entity')) {
            @trigger_error('Using the "--entity" option has been deprecated since version 3.0 and will be removed in 4.0. Pass it as argument instead.', E_USER_DEPRECATED);

            $input->setArgument('entity', $entityOption);
        }

        $question = new Question($questionHelper->getQuestion('The Entity shortcut name', $input->getArgument('entity')), $input->getArgument('entity'));
        $question->setValidator(array('Sensio\Bundle\GeneratorBundle\Command\Validators', 'validateEntityName'));

        $autocompleter = new EntitiesAutoCompleter($this->getContainer()->get('doctrine')->getManager());
        $autocompleteEntities = $autocompleter->getSuggestions();
        $question->setAutocompleterValues($autocompleteEntities);
        $entity = $questionHelper->ask($input, $output, $question);

        $input->setArgument('entity', $entity);
        list($bundle, $entity) = $this->parseShortcutNotation($entity);

        try {
            $entityClass = $this->getContainer()->get('doctrine')->getAliasNamespace($bundle).'\\'.$entity;
            $metadata = $this->getEntityMetadata($entityClass);
        } catch (\Exception $e) {
            throw new \RuntimeException(sprintf('Entity "%s" does not exist in the "%s" bundle. You may have mistyped the bundle name or maybe the entity doesn\'t exist yet (create it first with the "doctrine:generate:entity" command).', $entity, $bundle));
        }

        // write?
        $withWrite = $input->getOption('with-write') ?: false;
        $output->writeln(array(
            '',
            'By default, the generator creates two actions: list and show.',
            'You can also ask it to generate "write" actions: new, update, and delete.',
            '',
        ));
        $question = new ConfirmationQuestion($questionHelper->getQuestion('Do you want to generate the "write" actions', $withWrite ? 'yes' : 'no', '?', $withWrite), $withWrite);

        $withWrite = $questionHelper->ask($input, $output, $question);
        $input->setOption('with-write', $withWrite);

        // format
        $format = $input->getOption('format');
        $output->writeln(array(
            '',
            'Determine the format to use for the generated CRUD.',
            '',
        ));
        $question = new Question($questionHelper->getQuestion('Configuration format (yml, xml, php, or annotation)', $format), $format);
        $question->setValidator(array('Sensio\Bundle\GeneratorBundle\Command\Validators', 'validateFormat'));
        $format = $questionHelper->ask($input, $output, $question);
        $input->setOption('format', $format);

        // route prefix
        $prefix = $this->getRoutePrefix($input, $entity);
        $output->writeln(array(
            '',
            'Determine the routes prefix (all the routes will be "mounted" under this',
            'prefix: /prefix/, /prefix/new, ...).',
            '',
        ));
        $prefix = $questionHelper->ask($input, $output, new Question($questionHelper->getQuestion('Routes prefix', '/'.$prefix), '/'.$prefix));
        $input->setOption('route-prefix', $prefix);

        // summary
        $questionHelper->writeSection($output, 'Summary before generation');
        $output->writeln(array(
            sprintf('You are going to generate a CRUD controller for "<info>%s:%s</info>"', $bundle, $entity),
            sprintf('using the "<info>%s</info>" format.', $format),
            '',
        ));
    }
}
