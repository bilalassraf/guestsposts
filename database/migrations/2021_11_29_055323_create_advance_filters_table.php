<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvanceFiltersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advance_filters', function (Blueprint $table) {
            $table->id();
            $table->integer('authority')->default('0');
            $table->integer('raitings')->default('0');
            $table->integer('trust')->default('0');
            $table->integer('citation')->default('0');
            $table->integer('spam_score')->default('0');
            $table->double('ahrefs_traffic')->default('0');
            $table->double('sem_traffic')->default('0');
            $table->double('web_price')->default('0');
            $table->double('company_price')->default('0');
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
        Schema::dropIfExists('advance_filters');
    }
}
