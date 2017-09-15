<?php

namespace App\Utilities;

use Exception;
use SSD\Blade\Blade;
use SSD\DotEnv\DotEnv;
use SSD\StringConverter\Factory;
use Illuminate\Container\Container;

use App\Controllers\Controller;
use App\Controllers\ErrorController;

class App
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @var Blade
     */
    private $blade;

    /**
     * App constructor.
     *
     * @param Container $container
     * @param Blade $blade
     */
    public function __construct(Container $container, Blade $blade)
    {
        $this->container = $container;
        $this->blade = $blade;
    }

    /**
     * Call method on the controller.
     *
     * @return string
     */
    public function render()
    {
        try {

            $controller = $this->controller();

            $controller = new $controller(
                $this->blade,
                $this->container
            );

            $method = $this->method($controller);

            return $controller->{$method}();

        } catch(Exception $e) {

            return (new ErrorController($this->blade, $this->container))
                    ->index($this->errorMessage($e));

        }
    }

    /**
     * Get 404 message.
     *
     * @param Exception $e
     * @return string
     */
    private function errorMessage(Exception $e)
    {
        if ( ! DotEnv::is('APP_ENV', 'live')) {
            return $e->getMessage();
        }

        return $this->liveErrorMessage();
    }

    /**
     * Get 404 message for live environment.
     *
     * @return string
     */
    private function liveErrorMessage()
    {
        return 'The page you are trying to access does not exist.';
    }

    /**
     * Get controller name with namespace.
     *
     * @return string
     */
    private function controller()
    {
        $controller = $this->container->make('request')->segment(1);

        if (empty($controller)) {
            $controller = 'login';
        }

        $controller = $this->controllerName($controller);
        $controller = "\\App\\Controllers\\{$controller}";

        if ( ! class_exists($controller)) {
            $controller = "\\App\\Controllers\\PageController";
        }

        return $controller;
    }

    /**
     * Get controller class name.
     *
     * @param string $name
     * @return string
     */
    private function controllerName($name)
    {
        return Factory::hyphenToClassName($name) . 'Controller';
    }

    /**
     * Get method name.
     *
     * @param Controller $controller
     * @return string
     * @throws Exception
     */
    private function method(Controller $controller)
    {
        $method = $this->container->make('request')->segment(2);

        if (empty($method)) {
            $method = 'index';
        }

        $method = $this->methodName($method);

        if ( ! method_exists($controller, $method)) {
            throw new Exception("Invalid method call " . get_class($controller). "::{$method}");
        }

        return $method;
    }

    /**
     * Get method name.
     *
     * @param string $name
     * @return string
     */
    private function methodName($name)
    {
        return Factory::hyphenToCamel($name);
    }

}















