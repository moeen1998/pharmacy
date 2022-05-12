<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParshaseDrugsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parshase_drugs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parshase_id')->onUpdate('cascade')->onDelete('cascade');
            $table->string('drug_name')->references('name')->on('drugs')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('qty');
            $table->float('price');
            $table->float('total');
            $table->float('disc');
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
        Schema::dropIfExists('parshase_drugs');
    }
}
