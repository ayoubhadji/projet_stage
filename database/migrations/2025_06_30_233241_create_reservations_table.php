<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_hotel')->constrained('hotels')->onDelete('cascade');

            $table->date('date_arrivee');
            $table->date('date_depart');
            $table->unsignedInteger('nombre_de_personne');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reservations');
    }
}
