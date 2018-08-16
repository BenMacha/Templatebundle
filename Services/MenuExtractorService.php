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

namespace Benmacha\TemplateBundle\Services;

use Benmacha\TemplateBundle\Annotations\MenuAnnotation;
use Benmacha\TemplateBundle\Model\Menu;
use Doctrine\Common\Annotations\Reader;
use Doctrine\Common\Util\ClassUtils;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouterInterface;

class MenuExtractorService
{
    const ANNOTATION_CLASS = 'Benmacha\\TemplateBundle\\Annotations\\MenuAnnotation';
    const ROUTE_CLASS = 'Sensio\\Bundle\\FrameworkExtraBundle\\Configuration\\Route';

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * @var Reader
     */
    protected $reader;

    public function __construct(ContainerInterface $container, RouterInterface $router, Reader $reader)
    {
        $this->container = $container;
        $this->router = $router;
        $this->reader = $reader;
    }

    /**
     * Return a list of route to inspect for ApiDoc annotation
     * You can extend this method if you don't want all the routes
     * to be included.
     *
     * @return Route[] An array of routes
     */
    public function getRoutes()
    {
        return $this->router->getRouteCollection()->all();
    }

    /**
     * Extracts annotations from all known routes.
     *
     * @param mixed $view
     *
     * @return array
     */
    public function all()
    {
        return $this->extractAnnotations($this->getRoutes());
    }

    /**
     * Returns an array of data where each data is an array with the following keys:
     *  - annotation
     *  - resource.
     *
     * @param array $routes array of Route-objects for which the annotations should be extracted
     * @param mixed $view
     *
     * @return array
     */
    public function extractAnnotations(array $routes)
    {
        $arrayMenu = array();
        $arrayGroup = array();

        foreach ($routes as $route) {
            if (!$route instanceof Route) {
                throw new \InvalidArgumentException(sprintf('All elements of $routes must be instances of Route. "%s" given', gettype($route)));
            }
            if ($method = $this->getReflectionMethod($route->getDefault('_controller'))) {
                /** @var MenuAnnotation $annotation */
                $annotation = $this->reader->getMethodAnnotation($method, static::ANNOTATION_CLASS);
                if ($annotation) {
                    $path = $this->reader->getMethodAnnotation($method, static::ROUTE_CLASS);

                    if ($annotation->getGroup() and !isset($arrayGroup[$annotation->getGroup()['name']])) {
                        $group = new Menu();

                        $group->setPath('#');
                        $group->setTitleName($annotation->getGroup()['name']);
                        $group->setTitleTrans($annotation->getGroup()['trans']);
                        if(isset($annotation->getGroup()['icon']))
                        $group->setTitleIcon($annotation->getGroup()['icon']);
                        if(isset($annotation->getGroup()['position']))
                        $group->setPosition($annotation->getGroup()['position']);
                        $group->setRoles($annotation->getRoles());

                        $arrayGroup[$annotation->getGroup()['name']] = $group;
                    }

                    $menu = new Menu();
                    $menu->setPath($path->getName());
                    $menu->setTitleName($annotation->getTitle()['name']);
                    $menu->setTitleTrans($annotation->getTitle()['trans']);
                    if(isset($annotation->getTitle()['icon']))
                    $menu->setTitleIcon($annotation->getTitle()['icon']);
                    if(isset($annotation->getTitle()['position']))
                    $menu->setPosition($annotation->getTitle()['position']);
                    $menu->setRoles($annotation->getRoles());
                    if ($annotation->getGroup()) {
                        $arrayGroup[$annotation->getGroup()['name']]->addChild($menu);
                    } else if ($menu->getPosition()){
                        $arrayMenu[$menu->getPosition()] = $menu;
                    }else {
                        $arrayMenu[] = $menu;
                    }
                }
            }
        }

        /** @var Menu $group */
        foreach ($arrayGroup as $group) {
            if($group->getPosition())
            $arrayMenu[$group->getPosition()] = $group;
            else
                $arrayMenu[] = $group;

        }

        return $arrayMenu;
    }

    /**
     * Returns the ReflectionMethod for the given controller string.
     *
     * @param string $controller
     *
     * @return \ReflectionMethod|null
     */
    public function getReflectionMethod($controller)
    {
        if (false === strpos($controller, '::') && 2 === substr_count($controller, ':')) {
            $controller = $this->controllerNameParser->parse($controller);
        }

        if (preg_match('#(.+)::([\w]+)#', $controller, $matches)) {
            $class = $matches[1];
            $method = $matches[2];
        } else {
            if (preg_match('#(.+):([\w]+)#', $controller, $matches)) {
                $controller = $matches[1];
                $method = $matches[2];
            }

            if ($this->container->has($controller)) {
                // BC SF < 3.0
                if (method_exists($this->container, 'enterScope')) {
                    $this->container->enterScope('request');
                    $this->container->set('request', new Request(), 'request');
                }
                $class = ClassUtils::getRealClass(get_class($this->container->get($controller)));
                // BC SF < 3.0
                if (method_exists($this->container, 'enterScope')) {
                    $this->container->leaveScope('request');
                }

                if (!isset($method) && method_exists($class, '__invoke')) {
                    $method = '__invoke';
                }
            }
        }

        if (isset($class) && isset($method)) {
            try {
                return new \ReflectionMethod($class, $method);
            } catch (\ReflectionException $e) {
            }
        }

        return null;
    }
}
