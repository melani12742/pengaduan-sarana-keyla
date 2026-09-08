<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('umpan_baliks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aspirasi_id')->constrained()->onDelete('cascade');
            $table->foreignId('admin_id')->constrained('users')->onDelete('cascade');
            $table->text('isi_umpan_balik');
            $table->string('lampiran')->nullable();
            $table->enum('jenis', ['internal', 'eksternal'])->default('internal');
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('umpan_baliks');
    }
};