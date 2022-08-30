<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Users', function (Blueprint $table) {
            $table->enum('add_casino_post',['on', 'off'])->default('off');
            $table->enum('view_all_casino_post',['on', 'off'])->default('off');
            $table->enum('view_deleted_casino_post',['on', 'off'])->default('off');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('User', function (Blueprint $table) {
            //
        });
    }
}
