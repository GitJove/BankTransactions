<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->increments('id')->comment('Auto increase ID');
            $table->integer('country_id')->unsigned()->comment('Country ID');
            $table->integer('division_id')->unsigned()->nullable()->index('division_id')->comment('Division ID');
            $table->string('name', 255)->default('')->comment('City Name');
            $table->string('full_name', 255)->nullable()->comment('City Fullname');
            $table->string('code', 64)->nullable()->comment('City Code');
            // $table->index(['country_id','division_id','name'], 'uniq_city');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cities');
    }
}
