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

namespace Benmacha\TemplateBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('TemplateBundle:Default:index.html.twig');
    }
}
