<?php

namespace Modules\Api\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use Modules\Base\Http\Controllers\BaseController;
use Modules\Api\Repositories\UserRepository;
use Modules\Api\Entities\UserLoginAttemptModel;
use Illuminate\Support\Facades\Auth;

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
        $result = [
            "error" => 'Error en las credenciales.'
        ];
        $codeResult = 403;

        $credentials = $request->only('email', 'password');

        if( Auth::attempt( $credentials ) ) {

            $user = Auth::user();
            $apiKey = $user->generateApiKey();

            UserLoginAttemptModel::create([
                'id_user' => $user->id,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            $codeResult = 200;
            $result = [
                "data" => [
                    'name' => $user->name,
                    'token' => $apiKey
                ]
            ];
        }

        return response($result, $codeResult);
    }

    public function logout(Request $request)
    {
        $result = [
            "error" => 'Usuario no autenticado.'
        ];
        $codeResult = 403;

        if( Auth::check() ) {

            $user = Auth::user();
            $user->api_token = null;
            $user->save();

            $codeResult = 200;
            $result = [
                'data' => 'Usuario deslogueado.'
            ];
        }

        return response($result, $codeResult);
    }
}

