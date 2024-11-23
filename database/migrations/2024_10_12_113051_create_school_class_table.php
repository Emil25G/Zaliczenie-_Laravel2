<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolClassTable extends Migration
{
    public function up()
    {
        Schema::create('school_class', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('teacher_id')->nullable();
            $table->string('full_class_name');
            $table->string('class_name');
            $table->string('grade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('school_class');
    }
}
