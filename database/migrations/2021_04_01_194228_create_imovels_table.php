<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImovelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imovels', function (Blueprint $table) {
            $table->increments('id');
            $table->foreign('id_client')->references('id')->on('clients');
            $table->string('type_imovel');
            $table->string('address');
            $table->string('number');
            $table->string('cep');
            $table->string('district');
            $table->string('city');
            $table->string('state');
            $table->string('iptu');
            $table->string('registration');
            $table->string('rip');
            $table->string('name_allotment');
            $table->string('number_allotment');
            $table->string('block_allotment');
            $table->string('name_building');
            $table->string('number_block');
            $table->string('number_apartment');
            $table->string('ccir');
            $table->string('itr');
            $table->string('incra');
            $table->string('name_farm');
            $table->string('latitude');
            $table->string('longitude');
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
        Schema::dropIfExists('imovels');
    }
}
