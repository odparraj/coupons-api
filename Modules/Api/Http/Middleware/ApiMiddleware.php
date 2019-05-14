<?php
/**
 * Created by PhpStorm.
 * User: oparra
 * Date: 4/8/19
 * Time: 7:47 AM
 */

namespace Modules\Api\Http\Middleware;


use Modules\Api\Http\Controllers\ApiController;
use Modules\Base\Http\Middleware\PermissibleMiddleware;

class ApiMiddleware extends PermissibleMiddleware
{
    protected $controllers = [
        ApiController::class
    ];

    protected $actions = [ ];
}