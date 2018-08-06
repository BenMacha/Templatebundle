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

    /*"render": function (data, type, full, meta) {
                    var ch = '';
                    ch += '<a href="' + Routing.generate('user_show', {
                        _locale: "{{ app.request.locale }}",
                        id: data
                    }) + '" class="btn btn-inline btn-primary btn-sm ladda-button" data-style="expand-right" data-size="s"><span class="ladda-label">{{ 'show'|trans({},'user') }}</span><span class="ladda-spinner"></span></a>';
                    ch += '<a href="' + Routing.generate('user_edit', {
                        _locale: "{{ app.request.locale }}",
                        id: data
                    }) + '" class="btn btn-inline btn-primary btn-sm ladda-button" data-style="expand-right" data-size="s"><span class="ladda-label">{{ 'edit'|trans({},'user') }}</span><span class="ladda-spinner"></span></a>';
                    return ch;
                }
     */

    public function datatableRaw($columns, $show, $edit, $remove)
    {
        $columns = json_decode($columns, true);
        for ($i = 0; count($columns) > $i; ++$i) {
            $columns[$i]['target'] = $i;
            $columns[$i]['data'] = str_replace('.', '_', $columns[$i]['name']);
            // $columns[$i]['render'] = "function (data, type, full, meta) {return getFormattedDate(data);}";
        }

        $action = array(
            'target' => count($columns),
            'name' => 't.id',
            'data' => 't_idddd',
            'render' => "function (data, type, full, meta) {var ch = ''; return ch;}",
        );

        $columns[] = $action;

        return $columns;
    }
}
