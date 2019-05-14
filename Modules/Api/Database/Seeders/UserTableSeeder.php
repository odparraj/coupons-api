<?php

namespace Modules\Api\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\Api\Entities\RoleModel;
use Modules\Api\Entities\UserModel;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Str;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Verificamos que no exista el id 1
        $insUser = UserModel::withTrashed()->whereId(1)->first();

        //Este usuario de sistema sólo debe permitir crear usuarios
        if (empty($insUser)) {
            $roleAdmin= RoleModel::create([
                'name'=>'Admin',
                'guard_name'=>'api',
                'uuid'=> Uuid::uuid4()
            ]);

            $password = Str::random();

            $insUser = UserModel::create([
                'uuid' => Uuid::uuid4(),
                'name' => 'System',
                'email' => 'system@system.com',
                'password' => Hash::make($password)
            ]);

            $insUser->assignRole('Admin');

            echo "Email: {$insUser->email} Password: {$password} \n";
        }

    }
}