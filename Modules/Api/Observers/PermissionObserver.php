<?php
/**
 * Created by PhpStorm.
 * User: oparra
 * Date: 4/8/19
 * Time: 12:20 PM
 */

namespace Modules\Api\Observers;



use Modules\Api\Entities\PermissionModel;
use Ramsey\Uuid\Uuid;

class PermissionObserver
{
    public function creating(PermissionModel $permissionModel)
    {
        $permissionModel->uuid= Uuid::uuid4();
    }

    /**
     * Handle the contact model "created" event.
     *
     * @param  \Modules\Api\Entities\PermissionModel  $permissionModel
     * @return void
     */
    public function created(PermissionModel $permissionModel)
    {
        //
    }

    /**
     * Handle the contact model "updated" event.
     *
     * @param  \Modules\Api\Entities\PermissionModel  $permissionModel
     * @return void
     */
    public function updated(PermissionModel $permissionModel)
    {
        //
    }

    /**
     * Handle the contact model "deleted" event.
     *
     * @param  \Modules\Api\Entities\PermissionModel  $permissionModel
     * @return void
     */
    public function deleted(PermissionModel $permissionModel)
    {
        //
    }

    /**
     * Handle the contact model "restored" event.
     *
     * @param  \Modules\Api\Entities\PermissionModel  $permissionModel
     * @return void
     */
    public function restored(PermissionModel $permissionModel)
    {
        //
    }

    /**
     * Handle the contact model "force deleted" event.
     *
     * @param  \Modules\Api\Entities\PermissionModel  $permissionModel
     * @return void
     */
    public function forceDeleted(PermissionModel $permissionModel)
    {
        //
    }
}