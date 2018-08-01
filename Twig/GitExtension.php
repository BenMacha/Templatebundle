<?php
/**
 * Created by PhpStorm.
 * User: developper
 * Date: 01/08/18
 * Time: 17:32
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
        return [
            new \Twig_SimpleFunction('git_version', [$this, 'git_version'], [
                'is_safe' => ['html'],
            ]),
            new \Twig_SimpleFunction('git_date', [$this, 'git_date'], [
                'is_safe' => ['html'],
            ]),
        ];
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