<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOperationTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operation_types', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');

            $table->string('name');
            $table->string('description');

            $table->timestamps();
            $table->softDeletes();

            $table->unsignedInteger('created_by')->nullable()->default(null);//->after('updated_at');
            $table->unsignedInteger('updated_by')->nullable()->default(null);//->after('created_by');
            $table->unsignedInteger('deleted_by')->nullable()->default(null);//->after('updated_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('operation_types');
    }
}
