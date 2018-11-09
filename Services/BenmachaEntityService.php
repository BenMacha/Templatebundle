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

namespace Benmacha\TemplateBundle\Services;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class BenmachaEntityService
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * BenmachaEntityService constructor.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param object $user
     * @param string $value
     *
     * @return JsonResponse
     */
    public function changeBoolean($user, $value)
    {
        $object = $this->em->getRepository(get_class($user))->changeBoolean($value);

        dump(get_class($user));
        die;

        return new JsonResponse(array());
    }
}
