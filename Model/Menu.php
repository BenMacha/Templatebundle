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

namespace Benmacha\TemplateBundle\Model;

class Menu
{
    /** @var string */
    protected $path;

    /** @var string */
    protected $titleName;

    /** @var string */
    protected $titleTrans;

    /** @var string */
    protected $titleIcon;

    /** @var string */
    protected $groupName;

    /** @var string */
    protected $groupTrans;

    /** @var string */
    protected $groupIcon;

    /** @var Menu */
    protected $parent;

    /** @var array */
    protected $roles;

    /**
     * Menu constructor.
     *
     * @param string $path
     * @param string $titleName
     * @param string $titleTrans
     * @param string $titleIcon
     * @param string $groupName
     * @param string $groupTrans
     * @param string $groupIcon
     * @param Menu   $parent
     * @param array  $roles
     */
    public function __construct(string $path, string $titleName, string $titleTrans, string $titleIcon, string $groupName, string $groupTrans, string $groupIcon, self $parent, array $roles)
    {
        $this->path = $path;
        $this->titleName = $titleName;
        $this->titleTrans = $titleTrans;
        $this->titleIcon = $titleIcon;
        $this->groupName = $groupName;
        $this->groupTrans = $groupTrans;
        $this->groupIcon = $groupIcon;
        $this->parent = $parent;
        $this->roles = $roles;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getTitleName(): string
    {
        return $this->titleName;
    }

    /**
     * @param string $titleName
     */
    public function setTitleName(string $titleName): void
    {
        $this->titleName = $titleName;
    }

    /**
     * @return string
     */
    public function getTitleTrans(): string
    {
        return $this->titleTrans;
    }

    /**
     * @param string $titleTrans
     */
    public function setTitleTrans(string $titleTrans): void
    {
        $this->titleTrans = $titleTrans;
    }

    /**
     * @return string
     */
    public function getTitleIcon(): string
    {
        return $this->titleIcon;
    }

    /**
     * @param string $titleIcon
     */
    public function setTitleIcon(string $titleIcon): void
    {
        $this->titleIcon = $titleIcon;
    }

    /**
     * @return string
     */
    public function getGroupName(): string
    {
        return $this->groupName;
    }

    /**
     * @param string $groupName
     */
    public function setGroupName(string $groupName): void
    {
        $this->groupName = $groupName;
    }

    /**
     * @return string
     */
    public function getGroupTrans(): string
    {
        return $this->groupTrans;
    }

    /**
     * @param string $groupTrans
     */
    public function setGroupTrans(string $groupTrans): void
    {
        $this->groupTrans = $groupTrans;
    }

    /**
     * @return string
     */
    public function getGroupIcon(): string
    {
        return $this->groupIcon;
    }

    /**
     * @param string $groupIcon
     */
    public function setGroupIcon(string $groupIcon): void
    {
        $this->groupIcon = $groupIcon;
    }

    /**
     * @return Menu
     */
    public function getParent(): self
    {
        return $this->parent;
    }

    /**
     * @param Menu $parent
     */
    public function setParent(self $parent): void
    {
        $this->parent = $parent;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param array $roles
     */
    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }
}
