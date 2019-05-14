<?php
/**
 * Created by PhpStorm.
 * User: oparra
 * Date: 4/8/19
 * Time: 7:52 AM
 */

namespace Modules\Api\Http\Middleware;


use Modules\Api\Http\Controllers\PermissionsController;
use Modules\Base\Http\Middleware\PermissibleMiddleware;

class PermissionsMiddleware extends PermissibleMiddleware
{
    protected $controllers = [
        PermissionsController::class
    ];

    protected $actions = ['index', 'store', 'update','delete'];
}