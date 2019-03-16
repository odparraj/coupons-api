<?php

namespace Modules\Api\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\Api\Entities\UserModel;
use Ramsey\Uuid\Uuid;

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

            $insUser = UserModel::create([
                'uuid' => Uuid::uuid4(),
                'name' => 'System',
                'email' => 'system@admin.com',
                'password' => Hash::make('123456')
            ]);

            echo "Email: {$insUser->email} Password: 123456 \n";
        }

    }
}