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
        Schema::create('surats', function (Blueprint $table) {
            $table->id();
            $table->string('fullname');
            $table->string('email');
            $table->string('phone_number');
            $table->string('nik');
            $table->longText('ktp');
            $table->string('address');
            $table->string('position');
            $table->string('company_name');
            $table->string('company_npwp');
            $table->string('company_address');
            $table->string('company_phone');
            $table->string('no_surat');
            $table->string('data_center');
            $table->string('no_rack');
            $table->string('switch');
            $table->string('port');
            $table->string('service');
            $table->string('waktu_layanan');
            $table->string('os');
            $table->string('arsitektur');
            $table->string('control_panel');
            $table->string('servers');
            $table->string('support_signature');
            $table->string('support_name');
            $table->string('support_email');
            $table->string('client_signature');
            $table->longText('dokumentasi');
            $table->unsignedBigInteger('productId');
            $table->string('uuid_visitdc')->index();
            $table->foreign('uuid_visitdc')->references('UID')->on('visit_dcs')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surats');
    }
};
