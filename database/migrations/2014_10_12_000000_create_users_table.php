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
        Schema::create('users', function (Blueprint $table) {
            $table->integer('id')->index();
            $table->unsignedBigInteger('id_user')->primary();
            $table->string('name')->index();
            $table->string('email')->unique();
            $table->longText('ktp')->nullable();
            $table->string('phone')->unique();
            $table->string('nik')->nullable();
            $table->string('position')->nullable();
            $table->longText('address');
            $table->string('company_name');
            $table->longText('company_address');
            $table->string('company_phone')->nullable();
            $table->string('no_npwp')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
