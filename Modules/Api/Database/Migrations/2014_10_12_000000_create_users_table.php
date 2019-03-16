<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('api_token', 60)->unique()->nullable()->default(null);
            $table->rememberToken();
            
            $table->timestamps();
            $table->softDeletes();
            
            $table->unsignedInteger('created_by')->nullable()->default(null);//->after('created_at');
            $table->unsignedInteger('updated_by')->nullable()->default(null);//->after('updated_at');
            $table->unsignedInteger('deleted_by')->nullable()->default(null);//->after('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
