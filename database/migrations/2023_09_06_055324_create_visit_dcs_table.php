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
        Schema::create('visit_dcs', function (Blueprint $table) {
            $table->string('UID')->primary();
            $table->unsignedBigInteger('id_user')->unique();
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('lead_name')->index();
            $table->foreign('lead_name')->references('name')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('lead_email')->unique();
            $table->integer('lead_phone');
            $table->integer('lead_nik');
            $table->string('lead_ktp');
            $table->string('lead_signature');
            $table->string('company_name');
            $table->string('reason');
            $table->string('data_center');
            $table->string('Date');
            $table->string('teams');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visit_dcs');
    }
};
