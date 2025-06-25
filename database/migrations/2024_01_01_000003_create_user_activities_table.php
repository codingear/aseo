<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('activity_id')->constrained()->onDelete('cascade');
            $table->foreignId('weekday_id')->constrained()->onDelete('cascade');
            $table->boolean('is_completed')->default(false);
            $table->date('assigned_date')->nullable();
            $table->timestamps();
            
            $table->unique(['user_id', 'activity_id', 'weekday_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_activities');
    }
};
