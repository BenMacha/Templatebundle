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

use Doctrine\ORM\EntityManager;

class DataTableExtension extends \Twig_Extension
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

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('DatatableRaw', array($this, 'datatableRaw'), array(
                'is_safe' => array('html'),
            )),
        );
    }

    /**
     * @param $columns
     * @param $show
     * @param $edit
     * @param $remove
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     *
     * @return array|mixed
     */
    public function datatableRaw($columns, $show, $edit, $remove)
    {
        $columns = json_decode($columns, true);
        for ($i = 0; count($columns) > $i; ++$i) {
            $columns[$i]['target'] = $i;
            $columns[$i]['data'] = str_replace('.', '_', $columns[$i]['name']);
            // $columns[$i]['render'] = "function (data, type, full, meta) {return getFormattedDate(data);}";
        }

        $ch = '';
        if ($show) {
            $ch .= $this->twig->render('@BenmachaTemplate/layout/action/show.html.twig', array(
                'path' => $show,
            ));
        }

        if ($edit) {
            $ch .= $this->twig->render('@BenmachaTemplate/layout/action/edit.html.twig', array(
                'path' => $edit,
            ));
        }

        if ($remove) {
            $ch .= $this->twig->render('@BenmachaTemplate/layout/action/remove.html.twig', array(
                'path' => $remove,
            ));
        }

        $action = array(
            'target' => count($columns),
            'name' => 't.id',
            'data' => 't_id',
            'render' => "function (data, type, full, meta) {return '".$ch."';}",
        );

        $columns[] = $action;

        return $columns;
    }
}
