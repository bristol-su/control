<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateControlRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('control_roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('data_provider_id')->unique();
            $table->unsignedInteger('position_id');
            $table->unsignedInteger('group_id');
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
        Schema::dropIfExists('control_roles');
    }
}
