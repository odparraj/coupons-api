<?php


namespace Modules\Api\Entities;


use Modules\Base\Entities\BaseSecurityModel;

class OperationTypeModel extends BaseSecurityModel
{
    protected $table = 'operation_types';

    public $timestamps = true;

    protected $fillable = [
        'uuid', 'name', 'description'
    ];

    protected $dates = ['deleted_at'];
}