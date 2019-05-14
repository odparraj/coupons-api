<?php
/**
 * Created by PhpStorm.
 * User: oparra
 * Date: 4/8/19
 * Time: 7:57 AM
 */

namespace Modules\Api\Http\Middleware;


use Modules\Api\Http\Controllers\UsersController;
use Modules\Base\Http\Middleware\PermissibleMiddleware;

class UsersMiddleware extends PermissibleMiddleware
{
    protected $controllers = [
        UsersController::class
    ];

    protected $actions = ['index', 'store', 'update', 'delete', 'syncRoles', 'userRoles'];
}