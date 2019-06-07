<?php


namespace Modules\Api\Database\Seeders;


use Illuminate\Database\Seeder;
use Modules\Api\Entities\OperationTypeModel;
use Ramsey\Uuid\Uuid;

class OperationTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OperationTypeModel::create([
            'uuid' => Uuid::uuid4(),
            'name' => 'Asignación de cupo',
            'description' => 'Esta operación establece el cupo del usuario cliente'
        ]);

        OperationTypeModel::create([
            'uuid' => Uuid::uuid4(),
            'name' => 'Actualizacion de cupo',
            'description' => 'Esta operación permite actualizar el amount del cupo y activarlo o desactivarlo'
        ]);
    }
}