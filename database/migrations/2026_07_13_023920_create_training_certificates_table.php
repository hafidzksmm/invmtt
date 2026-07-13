<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('training_certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('provider_id')
                ->constrained('training_providers')
                ->onDelete('cascade');

            $table->string('title')->nullable();       // nama sertifikasi, mis. "Dell PowerEdge Certified"
            $table->string('holder_name')->nullable();  // nama karyawan pemegang sertifikat
            $table->date('issued_date')->nullable();    // tanggal terbit
            $table->date('expired_date')->nullable();   // tanggal kadaluarsa (opsional)
            $table->string('file_path');                // path gambar sertifikat
            $table->text('note')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('training_certificates');
    }
};
