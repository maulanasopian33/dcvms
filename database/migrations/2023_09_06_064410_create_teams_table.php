<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->string('UID')->primary();
            $table->unsignedBigInteger('lead_id')->index();
            $table->foreign('lead_id')->references('id_user')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('name');
            $table->string('nik')->nullable();
            $table->longText('ktp')->nullable();
            $table->string('email');
            $table->string('phone');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
