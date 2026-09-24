<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('aspirasis', function (Blueprint $table) {
            $table->id();

            // Relasi ke user (pembuat aspirasi)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Relasi ke kategori
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('cascade');

            // Data aspirasi
            $table->string('judul', 200);
            $table->text('deskripsi');
            $table->string('lokasi')->nullable();

            // ✅ FOTO BUKTI KERUSAKAN
            $table->string('foto')->nullable();

            // ✅ STATUS (5 STATUS BARU)
            $table->enum('status', ['menunggu', 'ditinjau', 'dalam_perbaikan', 'selesai', 'ditolak'])
                ->default('menunggu');

            // ✅ UPVOTES (FITUR DUKUNGAN)
            $table->integer('upvotes_count')->default(0);

            // ✅ PRIORITAS (TINGKAT URGENSI)
            $table->enum('prioritas', ['rendah', 'sedang', 'tinggi', 'urgent'])->default('sedang');

            // ✅ ANONIM (PENGADUAN ANONIM)
            $table->boolean('is_anonymous')->default(false);

            // ✅ TANGGAL
            $table->date('tanggal_selesai')->nullable();
            $table->date('tanggal_aspirasi')->nullable();

            // Timestamps
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('aspirasis');
    }
};