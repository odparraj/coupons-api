<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotas', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');

            $table->unsignedInteger('user_id');
            $table->double('amount_enabled');
            $table->double('amount_available');

            $table->boolean('is_active')->default(true);

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
        Schema::dropIfExists('quotas');
    }
}
