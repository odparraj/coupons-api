<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');

            $table->unsignedInteger('quota_id');
            $table->unsignedInteger('operation_type_id');

            $table->double('amount');
            $table->double('amount_old');
            $table->double('amount_new');

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
        Schema::dropIfExists('transactions');
    }
}
