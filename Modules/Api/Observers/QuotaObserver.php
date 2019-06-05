<?php


namespace Modules\Api\Observers;


use Modules\Api\Entities\QuotaModel;
use Modules\Api\Entities\TransactionModel;
use Ramsey\Uuid\Uuid;

class QuotaObserver
{
    public function creating(QuotaModel $quotaModel)
    {
        $quotaModel->uuid= Uuid::uuid4();
        $quotaModel->amount_available= $quotaModel->amount_enabled;
        $quotaModel->is_active= true;
    }

    /**
     * Handle the contact model "created" event.
     *
     * @param  \Modules\Api\Entities\QuotaModel  $quotaModel
     * @return void
     */
    public function created(QuotaModel $quotaModel)
    {
        TransactionModel::create([
            'uuid' => Uuid::uuid4(),
            'quota_id' => $quotaModel->id,
            'operation_type_id' => 1,
            'amount' => $quotaModel->amount_enabled,
            'amount_old' => 0,
            'amount_new' => $quotaModel->amount_enabled,
        ]);
    }

    /**
     * Handle the contact model "updated" event.
     *
     * @param  \Modules\Api\Entities\QuotaModel  $quotaModel
     * @return void
     */
    public function updated(QuotaModel $quotaModel)
    {
        //
    }

    /**
     * Handle the contact model "deleted" event.
     *
     * @param  \Modules\Api\Entities\QuotaModel  $quotaModel
     * @return void
     */
    public function deleted(QuotaModel $quotaModel)
    {
        //
    }

    /**
     * Handle the contact model "restored" event.
     *
     * @param  \Modules\Api\Entities\QuotaModel  $quotaModel
     * @return void
     */
    public function restored(QuotaModel $quotaModel)
    {
        //
    }

    /**
     * Handle the contact model "force deleted" event.
     *
     * @param  \Modules\Api\Entities\QuotaModel  $quotaModel
     * @return void
     */
    public function forceDeleted(QuotaModel $quotaModel)
    {
        //
    }
}