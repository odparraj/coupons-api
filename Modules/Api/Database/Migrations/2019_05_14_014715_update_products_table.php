<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->uuid('uuid')->after('id');

            $table->enum('type', ['product', 'service' , 'additional'])->after('meta_description');
            $table->unsignedBigInteger('parent_id')->nullable()->after('type');
            
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
        //Schema::dropIfExists('products');
    }
}
