<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('blocked_times', function (Blueprint $table) {
            $table->id();

            $table->foreignId('field_id')->constrained('fields')->onDelete('cascade');

            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');

            $table->string('reason')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('blocked_times');
    }

};
