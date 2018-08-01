<?php
/**
 * Created by PhpStorm.
 * User: developper
 * Date: 01/08/18
 * Time: 17:33
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
        return [
            'localize_route' => new \Twig_SimpleFunction('localize_route', [$this, 'localize_route'], ['is_safe' => ['html']]),
        ];
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