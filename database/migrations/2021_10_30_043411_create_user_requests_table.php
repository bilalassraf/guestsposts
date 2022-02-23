<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('web_name')->default('rkixtech');
            $table->string('Coordinator')->default('aziz');
            $table->double('price')->default('0');
            $table->string('category')->nullable();
            $table->double('company_price')->default('0');
            $table->string('domain_authority')->nullable();
            $table->string('span_score')->default('0');
            $table->string('domain_rating')->nullable();
            $table->string('organic_trafic_ahrefs')->nullable();
            $table->string('organic_trafic_sem')->nullable();
            $table->string('trust_flow')->nullable();
            $table->string('citation_flow')->nullable();
            $table->string('email_webmaster')->nullable();
            $table->text('web_description')->nullable();
            $table->text('special_note')->nullable();
            $table->enum('status', ['approved','rejected','deleted','pending'])->default('pending');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_requests');
    }
}
