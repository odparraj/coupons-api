<?php


namespace Modules\Api\Entities;


use Modules\Base\Entities\BaseSecurityModel;

class TransactionModel extends BaseSecurityModel
{
    protected $table = 'transactions';

    public $timestamps = true;

    protected $fillable = [
        'uuid', 'quota_id', 'operation_type_id', 'amount', 'amount_old', 'amount_new',
    ];

    protected $with= [
        'operationType'
    ];

    protected $dates = ['deleted_at'];


    public  function  operationType()
    {
        return $this->belongsTo(OperationTypeModel::class,'operation_type_id', 'id');
    }
}