<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('training_providers', function (Blueprint $table) {
            $table->id();
            $table->string('name');           // Dell, Lenovo, D-Link, Sophos, dll
            $table->string('logo_path')->nullable(); // path logo penyedia
            $table->integer('position')->default(0); // urutan tampil di dashboard
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('training_providers');
    }
};
