<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->string('type')->nullable();
            $table->text('explain')->nullable();
            $table->string('sediaan')->nullable();
            $table->boolean('is_tuslah')->default(0);
            $table->string('barcode_code')->nullable();
            $table->double('purchase_price')->nullable();
            $table->boolean('is_percentage')->default(0);
            $table->float('profit')->nullable();
            $table->integer('inventory_category_id')->unsigned()->nullable();
            $table->foreign('inventory_category_id')->references('id')->on('inventory_categories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventories');
    }
}
