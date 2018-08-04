<?php

namespace Benmacha\TemplateBundle\Twig;
/**
 * Created by PhpStorm.
 * User: developper
 * Date: 01/08/18
 * Time: 17:28
 */

use Doctrine\ORM\EntityManager;

/**
 * Class Menu.
 */
class MenuExtention extends \Twig_Extension
{
    protected $em;
    protected $twig;

    /**
     * Menu constructor.
     *
     * @param EntityManager     $entityManager
     * @param \Twig_Environment $twig
     */
    public function __construct(EntityManager $entityManager, \Twig_Environment $twig)
    {
        $this->twig = $twig;
        $this->em = $entityManager;
    }

    /**
     * @return array available Twig functions
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('Menu_build', [$this, 'build'], [
                'is_safe' => ['html'],
            ]),
        ];
    }

    /**
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function build()
    {
        return $this->twig->render('BenmachaTemplateBundle:Menu:builder.html.twig', []);
    }
}