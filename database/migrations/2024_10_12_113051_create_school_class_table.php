<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolClassTable extends Migration
{
    public function up()
    {
        Schema::create('school_class', function (Blueprint $table) {
            $table->id(); // Unikalne ID klasy
            $table->unsignedBigInteger('teacher_id')->nullable(); // ID nauczyciela
            $table->string('class_name'); // Nazwa klasy np. A, B, C
            $table->string('grade'); // Numer klasy np. 1, 2, 3 itd.
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('school_class');
    }
}
