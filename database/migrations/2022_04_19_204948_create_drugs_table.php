<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDrugsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drugs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->float('disc');
            $table->float('avilablesunit');
            $table->float('smallprice');
            $table->integer('packet');
            $table->integer('min');
            $table->boolean('short');
            $table->string('place_name')->references('name')->on('placees')->onUpdate('cascade')->onDelete('cascade');
            $table->string('category_name')->references('name')->on('categories')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('drugs');
    }
}
