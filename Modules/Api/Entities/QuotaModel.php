<?php


namespace Modules\Api\Entities;


use Modules\Base\Entities\BaseSecurityModel;

class QuotaModel extends BaseSecurityModel
{
    protected $table = 'quotas';

    public $timestamps = true;

    protected $fillable = [
        'uuid', 'user_id', 'amount_enabled', 'amount_available', 'is_active',
    ];

    protected $dates = ['deleted_at'];

}