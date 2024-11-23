<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersIndexTable extends Migration
{
    public function up()
    {
        Schema::create('users_index', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('class_id')->nullable();
            $table->string('index');
            $table->boolean('status');
            $table->timestamps();

            $table->foreign('class_id')
                ->references('id')
                ->on('school_class')
                ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('users_index');
    }
}
