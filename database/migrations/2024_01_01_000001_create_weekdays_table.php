<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('weekdays', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('day_number'); // 1=Monday, 7=Sunday
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('weekdays');
    }
};
