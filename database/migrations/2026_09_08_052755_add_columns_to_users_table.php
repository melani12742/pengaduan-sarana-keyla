<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Tambahkan kolom role
            $table->enum('role', ['admin', 'guest'])->default('guest')->after('password');

            // Tambahkan kolom no_telepon
            $table->string('no_telepon', 15)->nullable()->after('role');

            // Tambahkan kolom alamat
            $table->text('alamat')->nullable()->after('no_telepon');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'no_telepon', 'alamat']);
        });
    }
};