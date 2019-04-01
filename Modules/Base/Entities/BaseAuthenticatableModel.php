<?php

namespace Modules\Base\Entities;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Wildside\Userstamps\Userstamps;
use EloquentFilter\Filterable;

class BaseAuthenticatableModel extends Authenticatable
{
    use Notifiable, SoftDeletes, Filterable, Userstamps;

    protected $guard_name = 'api';
    protected $table = 'users';
    public $timestamps = true;
    protected $dates = ['deleted_at'];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function generateApiKey()
    {
        do {
           $this->api_token = Str::random(60);
        } while ( $this->where('api_token', $this->api_token)->exists() );
        
        $this->save();
        
        return $this->api_token;
    }
    
    //Para el filtrado - Hacer traids
    public function modelFilter($filter = null)
    {
        if ($filter === null) {
            $classModel = class_basename($this);
            $dirModels = join('', explode($classModel, get_class($this)));
            $filter = str_replace('\\Entities\\', '\\Filters\\', $dirModels) . str_replace('Model', 'Filter', $classModel);
        }

        return $filter;
    }

    //Para sobre escribir la clave del id que utiliza laravel para hacer el route-model-binding (https://scotch.io/tutorials/cleaner-laravel-controllers-with-route-model-binding)
    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
