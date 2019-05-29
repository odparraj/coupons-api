<?php

namespace Modules\Api\Http\Middleware\Base;

use Closure;
use Illuminate\Support\Facades\Route;
use Modules\Base\General\ResponseBuilder;

class PermissibleMiddleware
{
    /**
     * List of actions with their mapping name to exclude.
     *
     * @var array
     */
    protected $excludedActions = [];

    /**
     * List of middlewares with their mapping name to check.
     *
     * @var array
     */
    protected $middleware = ['auth:api'];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! $this->shouldHandle($request)) {
            return $next($request);
        }

        if (! $request->user()) {
            return ResponseBuilder::error(101);
        }
        if (method_exists ($request->user(),'hasRole') && $request->user()->can($this->getPermission($request))) {
            return $next($request);
        }

        return ResponseBuilder::error(101);
    }

    /**
     * Should the request be handled.
     *
     * @param $request
     * @return bool
     */
    protected function shouldHandle($request): bool
    {
        return $this->checkRoute($request) && $this->checkAction($request);
    }

    /**
     * Check if the route should be handle.
     *
     * @param $request
     * @return bool
     */
    protected function checkRoute($request): bool
    {

        $routeCollection = Route::getRoutes();
        $routes= [];

        foreach ($routeCollection as $route) {
            $routes[] =[
                'name' => $route->getActionName(),
                'middleware'=> $route->middleware()
            ];
        }

        $middleware= $this->middleware;

        return collect($routes)->contains(function ($item) use ($request, $middleware) {
            return $item['name'] == $request->route()->getActionName() && collect($middleware)->contains(function ($element) use($item){
                    return in_array($element, $item['middleware']);
                });
        });
    }

    /**
     * Check if the action should be handle.
     *
     * @param $request
     * @return bool
     */
    protected function checkAction($request): bool
    {
        return ! collect($this->excludedActions)->contains(function ($item, $key) use ($request) {
            $actionMethod= $request->route()->getActionMethod();
            $middleware= $request->route()->middleware();
            return in_array($actionMethod, $item) && in_array($key, $middleware);
        });
    }

    /**
     * Get the permission name for the given request.
     *
     * @param $request
     * @return string
     */
    protected function getPermission($request)
    {
        return $request->route()->getActionName();
    }

    /**
     * Get the exclude actions configurated.
     *
     * @return array
     */

    public function getExcludeActions()
    {
        return $this->excludedActions;
    }

}
