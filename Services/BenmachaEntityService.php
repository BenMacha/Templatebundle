<?php
/**
 * Created by PhpStorm.
 * User: developper
 * Date: 20/08/18
 * Time: 19:29
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

        dump(get_class($user));die;

        return new JsonResponse(array());
    }
}