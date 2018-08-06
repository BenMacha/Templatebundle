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

namespace Benmacha\TemplateBundle\Twig;

/*
 * Class GIT.
 */
class GitExtension extends \Twig_Extension
{
    /**
     * @return array
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('git_version', array($this, 'git_version'), array(
                'is_safe' => array('html'),
            )),
            new \Twig_SimpleFunction('git_date', array($this, 'git_date'), array(
                'is_safe' => array('html'),
            )),
        );
    }

    /**
     * @return string
     */
    public function git_version()
    {
        return trim(exec('git describe --abbrev=0 --tags'));
    }

    /**
     * @return string
     */
    public function git_date()
    {
        $commitDate = new \DateTime(trim(exec('git log -n1 --pretty=%ci HEAD')));

        return $commitDate->format('Y-m-d');
        //return $commitDate->format('Y-m-d H:m:s');
    }
}
