<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();

            // 🔥 SIAPA yang melakukan
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('user_name')->nullable();   // disimpan terpisah, jaga-jaga kalau user dihapus nanti nama tetap kebaca
            $table->string('user_role')->nullable();

            // 🔥 APA yang dilakukan
            $table->string('action');                  // created | updated | deleted
            $table->string('model_type');               // nama model, mis. "AsetJual"
            $table->unsignedBigInteger('model_id')->nullable();
            $table->string('description')->nullable();  // ringkasan singkat, mis. "Menambahkan data: Laptop Asus"

            // 🔥 DETAIL PERUBAHAN
            $table->json('old_values')->nullable();      // isi data sebelum diubah (untuk update/delete)
            $table->json('new_values')->nullable();       // isi data sesudah diubah (untuk create/update)

            // 🔥 JEJAK TAMBAHAN
            $table->string('ip_address')->nullable();

            $table->timestamp('created_at')->useCurrent();

            $table->index(['model_type', 'model_id']);
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
