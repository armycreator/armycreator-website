<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle;

use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Routing\RequestContext;

/**
 * Class DevRouter
 * @author Julien Deniau <julien.deniau@mapado.com>
 */
class DevRouter implements RouterInterface
{
    private $baseRouterExtension;

    private $requestStack;

    /**
     * @param mixed $baseRouterExtension
     */
    public function __construct($baseRouterExtension, $requestStack)
    {
        $this->baseRouter = $baseRouterExtension;
        $this->requestStack = $requestStack;
    }


    public function generate($name, $parameters = [], $relative = false)
    {
        $path = $this->baseRouter->generate($name, $parameters, $relative);

        $request = $this->requestStack->getMasterRequest();
        if ($request->query && $request->query->has('sid')) {
            $path .= '?sid=' . $request->query->get('sid');
        }

        return $path ;
    }

    //public function __call($name, $arguments)
    //{
    //    return call_user_func_array([$this->baseRouter, $name], $arguments);
    //}

    public function setContext(RequestContext $context)
    {
        return $this->baseRouter->setContext();
    }

    public function match ($pathinfo)
    {
        return $this->baseRouter->match($pathinfo);
    }

    public function getContext()
    {
        return $this->baseRouter->getContext();
    }

    public function getRouteCollection()
    {
        return $this->baseRouter->getRouteCollection();
    }
}
