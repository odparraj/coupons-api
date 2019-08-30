<?php

namespace Modules\Api\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

use Modules\Api\Entities\UserModel;
use Modules\Api\Http\Middleware\Base\PermissibleMiddleware;
use Modules\Base\Http\Controllers\BaseController;
use Modules\Api\Repositories\UserRepository;
use Modules\Api\Entities\UserLoginAttemptModel;
use Illuminate\Support\Facades\Auth;
use Modules\Base\General\ResponseBuilder;
use Modules\Base\Http\Resources\UuidNameJsonResource;
use Modules\Base\General\ApiCode;

class UsersController extends BaseController
{
    protected $uuidToId = [
        //'product_type_id'=> \Modules\CoreBanking\Entities\ProductTypeModel::class,
        //'company_id'=> \Modules\CoreBanking\Entities\CompanyModel::class,
    ];
    
    //companies agregar
    protected $arrValidate = [
        'name' => 'required|string|max:255',
        'email'=> 'required|string|unique:users',
        'password'=> 'required|string|min:6'
    ];

    public function __construct(UserRepository $repository)
    {
        parent::__construct($repository);

        $this->middleware(PermissibleMiddleware::class);
    }

    protected function __storeGet(Request $request)
    {
        $data = $request->input();

        $data['password'] = Hash::make($data['password']);

        return $data;
    }

    protected function __updateGet(Request $request)
    {
        $data = $request->input();

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return $data;
    }

    //Para los roles:
    //https://github.com/JosephSilber/bouncer
    //https://packagist.org/packages/spatie/laravel-permission

    public function login(Request $request)
    {
        $response = null;

        $credentials = $request->only('email', 'password');

        if( Auth::attempt( $credentials ) ) {

            $user = Auth::user();
            $apiKey = $user->generateApiKey();

            UserLoginAttemptModel::create([
                'id_user' => $user->id,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);
            
            $data = [
                'name' => $user->name,
                'token' => $apiKey
            ];

            $response = ResponseBuilder::success($data);
        }

        return $response ?? ResponseBuilder::errorWithMessage(ApiCode::AUTH_INVALID_CREDENTIALS,'Credenciales incorrectas',404);
    }

    public function logout(Request $request)
    {
        $response = null;

        if( Auth::check() ) {

            $user = Auth::user();
            $user->api_token = null;
            $user->save();

            $response = ResponseBuilder::success();
        }

        return $response ?? ResponseBuilder::errorWithMessage(ApiCode::AUTH_UNAUTHORIZED,"El tipo de usuario no tiene permitido realizar login",401);
    }

    public function syncRoles(Request $request, UserModel $user)
    {
        $rolesTableName = config('permission.table_names.roles');

        $request->validate([
            '*.id' => "required|exists:{$rolesTableName},uuid"
        ]);

        // Limpiamos la data obteniendo solo los uuid's
        $roles = Arr::pluck($request->all(),'id');

        $user->syncRoles($roles);

        return $this->userRoles($user);
    }

    public function userRoles(UserModel $user)
    {
        $result = UuidNameJsonResource::collection($user->roles);

        return ResponseBuilder::success($result->resolve());
    }

    public function meRoles(Request $request)
    {
        return $this->userRoles($request->user());
    }
}

