<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersLoginAttemptTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_logins_attempts', function (Blueprint $table) {
            $table->increments('id');
            
            $table->unsignedInteger('id_user');
            $table->ipAddress('ip');
            $table->text('user_agent');
            
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
        Schema::dropIfExists('users_logins_attempts');
    }
}
