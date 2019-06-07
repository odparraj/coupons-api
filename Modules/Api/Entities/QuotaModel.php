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

    protected $casts= [
        'is_active' => 'boolean'
    ];

    protected $dates = ['deleted_at'];

    public function transactions()
    {
        return $this->hasMany(TransactionModel::class,'quota_id','id');
    }

}