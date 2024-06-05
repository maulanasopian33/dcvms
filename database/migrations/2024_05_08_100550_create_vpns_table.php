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
        Schema::create('vpns', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('disabled');
            $table->string('vpnId');
            $table->string('localAddress');
            $table->string('remoteAddress');
            $table->string('password');
            $table->string('protocol')->default('PPTP');
            $table->string('host')->default('vpn.antmedia.id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vpns');
    }
};
