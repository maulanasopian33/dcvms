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
            $table->unsignedBigInteger('id_user')->index();
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('lead_name')->index();
            $table->foreign('lead_name')->references('name')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('lead_email')->index();
            $table->bigInteger('lead_phone');
            $table->bigInteger('lead_nik');
            $table->unsignedBigInteger('serverid')->index();
            $table->foreign('serverid')->references('productId')->on('productdetails')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('success')->default('0');
            $table->longText('lead_ktp');
            $table->longText('webcam');
            $table->longText('lead_signature');
            $table->string('company_name');
            $table->longText('server_maintenance');
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
