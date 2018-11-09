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

namespace Benmacha\TemplateBundle\Twig;

use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernel;

/**
 * Class LocalizedRouteExtension.
 */
class LocalizedRouteExtension extends \Twig_Extension
{
    private $request;
    private $router;

    /**
     * LocalizedRouteExtension constructor.
     *
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        // Just retrieve the router here
        $this->router = $router;
    }

    /*
     * Listen to the 'kernel.request' event to get the main request, this has several reasons:
     *  - The request can not be injected directly into a Twig extension, this causes a ScopeWideningInjectionException
     *  - Retrieving the request inside of the 'localize_route' method might yield us an internal request
     *  - Requesting the request from the container in the constructor breaks the CLI environment (e.g. cache warming)
     */

    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        if (HttpKernel::MASTER_REQUEST === $event->getRequestType()) {
            $this->request = $event->getRequest();
        }
    }

    public function getFunctions()
    {
        return array(
            'localize_route' => new \Twig_SimpleFunction('localize_route', array($this, 'localize_route'), array('is_safe' => array('html'))),
        );
    }

    /**
     * @param null $locale
     *
     * @return string
     */
    public function localize_route($locale = null)
    {
        // Merge query parameters and route attributes
        $attributes = array_merge($this->request->query->all(), $this->request->attributes->get('_route_params'));

        // Set/override locale
        $attributes['_locale'] = $locale ?: \Locale::getDefault();

        return $this->router->generate($this->request->attributes->get('_route'), $attributes);
    }

    /**S
     * @return string
     */
    public function getName()
    {
        return 'twig_localized_route_extension';
    }
}
