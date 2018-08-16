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

    /** @var int */
    protected $position;

    /** @var string */
    protected $titleName;

    /** @var string */
    protected $titleTrans;

    /** @var string */
    protected $titleIcon;

    /** @var array */
    protected $childs = array();

    /** @var array */
    protected $roles = array();

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
    public function getTitleIcon(): ?string
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

    /**
     * @param Menu $child
     */
    public function addChild(self $child): void
    {
        if($child->getPosition())
        $this->childs[$child->getPosition()] = $child;
        else
            $this->childs[] = $child;

        ksort($this->childs);
    }

    /**
     * @return array
     */
    public function getChilds(): array
    {
        return $this->childs;
    }

    /**
     * @param array $childs
     */
    public function setChilds(array $childs): void
    {
        $this->childs = $childs;
        ksort($this->childs);
    }

    /**
     * @return int
     */
    public function getPosition(): ?int
    {
        return $this->position;
    }

    /**
     * @param int $position
     */
    public function setPosition(int $position): void
    {
        $this->position = $position;
    }

}
