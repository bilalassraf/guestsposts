<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('name');
            $table->string('profile')->nullable();
            $table->string('cover')->nullable();
            $table->string('gender')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('country')->nullable();
            $table->string('province')->nullable();
            $table->string('postal')->nullable();
            $table->text('about')->nullable();
            $table->string('city')->nullable();
            $table->string('email')->unique();
            $table->string('greeting')->default('Wellcome Back,');
            $table->text('message')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->enum('type', ['user', 'admin'])->default('user');
            $table->enum('user_info',['on', 'off'])->default('off');
            $table->enum('add_guest_post',['on', 'off'])->default('off');
            $table->enum('view_all_guest_post',['on', 'off'])->default('off');
            $table->enum('view_deleted_guest_post',['on', 'off'])->default('off');
            $table->enum('add_niche',['on', 'off'])->default('off');
            $table->enum('view_niches',['on', 'off'])->default('off');
            $table->enum('deleted_niches',['on', 'off'])->default('off');
            $table->enum('add_category',['on', 'off'])->default('off');
            $table->enum('view_all_categories',['on', 'off'])->default('off');
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
        Schema::dropIfExists('users');
    }
}
