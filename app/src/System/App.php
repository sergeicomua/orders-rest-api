<?php

namespace App\System;

use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Router;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\HttpKernel\Controller;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\DependencyInjection;

use Symfony\Component\Routing;
use Symfony\Component\HttpKernel;




class App
{

    private $request;
    private $router;
    private $routes;
    private $requestContext;
    private $controller;
    private $arguments;
    private $basePath;

    private $container;

    private static $instance = null;

    public static function getInstance($basePath = null)
    {
        if (is_null(static::$instance)){
            static::$instance = new static($basePath);
        }

        return static::$instance;
    }

    private function __construct($basePath = null)
    {
        $this->basePath = $basePath;

        $this->setContainer();
        $this->setRequest();
        $this->setRequestContext();
        $this->setRouter();

        $this->routes = $this->router->getRouteCollection();

    }

    private function setContainer(){
        $this->container = new DependencyInjection\ContainerBuilder();
        $loader = new DependencyInjection\Loader\YamlFileLoader($this->container, new FileLocator(BASE_PATH.'/config'));
        $loader->load('services.yaml');
        $this->container->compile();
    }

    public function getContainer(){
        return $this->container;
    }

    private function setRequest()
    {
        $this->request = Request::createFromGlobals();
    }


    public  function getRequest()
    {
        return $this->request;
    }

    private function setRequestContext()
    {
        $this->requestContext = new RequestContext();
        $this->requestContext->fromRequest($this->request);
    }

    public function getRequestContext()
    {
        return $this->requestContext;
    }

    private function  setRouter()
    {
        $fileLocator = new FileLocator(array(__DIR__));

        $this->router = new Router(
            new YamlFileLoader($fileLocator),
            $this->basePath.'/config/routes.yaml',
            array('cache_dir' => $this->basePath.'/storage/cache')
        );
    }

    public function getController()
    {
        return (new Controller\ControllerResolver())->getController($this->request);

    }

    public function getArguments($controller)
    {
        return (new Controller\ArgumentResolver())->getArguments($this->request, $controller);
    }

    public function run()
    {
        $matcher = new Routing\Matcher\UrlMatcher($this->routes, $this->requestContext);

        try{
            $this->request->attributes->add($matcher->match($this->request->getPathInfo()));

            $this->controller = $this->getController();
            $this->arguments = $this->getArguments($this->controller);


            $response = call_user_func_array($this->controller, $this->arguments);

        }catch (\Exception $e){
            exit($e);
        }

        $response->send();
    }

    private function __clone()
    {

    }
}