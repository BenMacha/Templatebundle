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

namespace Benmacha\TemplateBundle\Annotations;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 */
class MenuAnnotation
{
    const DEFAULT_VIEW = 'default';

    /**
     * @Required
     *
     * @var array
     */
    public $title = array();

    /**
     * @var array
     */
    public $group = array();

    /**
     * @var array
     */
    public $roles = array();

    /**
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param array $roles
     */
    public function setRoles($roles): void
    {
        $this->roles = $roles;
    }

    /**
     * @return array
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @param string $group
     */
    public function setGroup($group)
    {
        $this->group = $group;
    }

    /**
     * @return array
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param array $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }
}
