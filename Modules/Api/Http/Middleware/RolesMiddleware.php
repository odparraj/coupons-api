<?php
/**
 * Created by PhpStorm.
 * User: oparra
 * Date: 4/8/19
 * Time: 3:58 PM
 */

namespace Modules\Api\Http\Middleware;


use Modules\Api\Http\Controllers\RolesController;
use Modules\Base\Http\Middleware\PermissibleMiddleware;

class RolesMiddleware extends PermissibleMiddleware
{
    protected $controllers = [
        RolesController::class
    ];

    protected $actions = ['index', 'store', 'update', 'delete', 'syncPermissions', 'rolePermissions'];
}