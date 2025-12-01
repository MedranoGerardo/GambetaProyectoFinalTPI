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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->foreignId('field_id')->constrained('fields')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // empleado que registró

            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');

            $table->decimal('total_price', 10, 2)->default(0);

            $table->enum('status', ['pendiente', 'confirmada', 'cancelada', 'finalizada'])
                ->default('pendiente');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reservations');
    }

};
