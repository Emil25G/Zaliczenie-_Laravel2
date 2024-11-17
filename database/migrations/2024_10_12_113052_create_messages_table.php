<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('msg_id'); // AUTO_INCREMENT
            $table->integer('incoming_msg_id')->unsigned();
            $table->integer('outgoing_msg_id')->unsigned();
            $table->string('msg', 1000);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
