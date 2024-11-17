<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupMessagesTable extends Migration
{
    public function up()
    {
        Schema::create('group_messages', function (Blueprint $table) {
            $table->increments('message_id');
            $table->integer('unique_id')->unsigned();
            $table->string('message', 500);
            $table->timestamp('timestamp')->useCurrent();
        });
    }

    public function down()
    {
        Schema::dropIfExists('group_messages');
    }
}
