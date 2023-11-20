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
        Schema::create('productdetails', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('productId')->index();
            $table->foreign('productId')->references('id')->on('products')->onDelete('cascade')->onUpdate('cascade');
            $table->string('visit_id');
            $table->string('merek');
            $table->string('jenis_server');
            $table->string('SN');
            $table->string('ukuran');
            $table->string('psu');
            $table->boolean('railkit');
            $table->string('datacenter');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productdetails');
    }
};
