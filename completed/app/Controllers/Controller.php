<?php

namespace App\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\View\Factory;
use Illuminate\Support\Collection;
use Illuminate\Container\Container;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

use SSD\Blade\Blade;

use App\Models\User;
use App\Utilities\Guard;
use App\Utilities\Event\Job;
use App\Utilities\Validator\Validator;
use App\Utilities\Event\EventDispatcher;

abstract class Controller
{
    /**
     * @var Blade
     */
    protected $blade;

    /**
     * @var Container
     */
    protected $container;

    /**
     * @var Guard
     */
    protected $guard;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var EventDispatcher
     */
    protected $event;

    /**
     * @var Validator
     */
    protected $validator;

    /**
     * @var Collection
     */
    protected $input;

    /**
     * @var array
     */
    protected $rules = [];

    /**
     * @var array
     */
    protected $errors = [];

    /**
     * Controller constructor.
     *
     * @param Blade $blade
     * @param Container $container
     */
    public function __construct(Blade $blade, Container $container)
    {
        $this->blade = $blade;
        $this->container = $container;
        $this->guard = $container->make('guard');
        $this->request = $container->make('request');
        $this->event = $container->make('event');
        $this->constructor();
    }

    /**
     * Add to parent constructor.
     *
     * @return void
     */
    protected function constructor() {}

    /**
     * Get view instance.
     *
     * @param null $view
     * @param array $data
     * @param array $mergeData
     * @return Factory|View
     */
    protected function view($view = null, $data = [], $mergeData = [])
    {
        return $this->blade->view($view, $data, $mergeData);
    }

    /**
     * Authorise request.
     *
     * @return null|Response
     */
    protected function authorise()
    {
        if ($this->guard->isAuthenticated()) {
            return null;
        }

        return (new RedirectResponse('/'))->send();
    }

    /**
     * Redirect if user is logged in.
     *
     * @return null|Response
     */
    protected function redirectIfLoggedIn()
    {
        if ( ! $this->guard->isAuthenticated()) {
            return null;
        }

        return (new RedirectResponse('/dashboard'))->send();
    }

    /**
     * Check if request method is POST.
     *
     * @return bool
     */
    protected function isPost()
    {
        return $this->request->method() === 'POST';
    }

    /**
     * Only allow POST request method.
     *
     * @return void
     * @throws BadRequestHttpException
     */
    protected function postRequestOnly()
    {
        if ( ! $this->isPost()) {
            throw new BadRequestHttpException("Invalid request method!");
        }
    }

    /**
     * Collect request items.
     *
     * @param array $items
     */
    protected function collectRequest(array $items)
    {
        $this->input = new Collection(
            $this->request->only($items)
        );
    }

    /**
     * Validate request
     *
     * @return void
     */
    protected function validateRequest()
    {
        $this->validator = new Validator(
            new Collection($this->rules),
            $this->input
        );

        if ( ! $this->validator->isValid()) {

            $this->errors = array_merge(
                $this->errors,
                $this->validator->errors
            );

        }
    }

    /**
     * Add item to errors.
     *
     * @param string $key
     * @param string $rule
     */
    protected function addError($key, $rule)
    {
        if (
            array_key_exists($key, $this->errors) &&
            in_array($rule, $this->errors[$key])
        ) {
            return;
        }

        $this->errors[$key][] = $rule;
    }

    /**
     * Get user by token.
     *
     * @return User|null
     */
    protected function getUserByToken()
    {
        $token = $this->request->get('token');

        if (empty($token) || is_null($user = User::byToken($token)->first())) {
            return null;
        }

        return $user;
    }

    /**
     * Dispatch events.
     *
     * @param Job|array $events
     * @return mixed
     */
    protected function dispatch($events)
    {
        return $this->event->dispatch($events);
    }
}