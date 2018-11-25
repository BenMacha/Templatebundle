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

namespace Benmacha\TemplateBundle\Twig;

/*
 * Created by PhpStorm.
 * User: developper
 * Date: 01/08/18
 * Time: 17:28
 */

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class Menu.
 */
class MenuExtention extends \Twig_Extension
{
    protected $em;
    protected $twig;
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * Menu constructor.
     *
     * @param EntityManager     $entityManager
     * @param \Twig_Environment $twig
     */
    public function __construct(ContainerInterface $container, EntityManagerInterface $entityManager, \Twig_Environment $twig)
    {
        $this->twig = $twig;
        $this->em = $entityManager;
        $this->container = $container;
    }

    /**
     * @return array available Twig functions
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('Menu_build', array($this, 'build'), array(
                'is_safe' => array('html'),
            )),
        );
    }

    /**
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     *
     * @return string
     */
    public function build()
    {
        $extractorService = $this->container->get('benmacha.twig.menu.extractor');

        dump($extractorService->all());


        return $this->twig->render('BenmachaTemplateBundle:Menu:builder.html.twig', array(
            'menus' => $extractorService->all(),
        ));
    }
}
