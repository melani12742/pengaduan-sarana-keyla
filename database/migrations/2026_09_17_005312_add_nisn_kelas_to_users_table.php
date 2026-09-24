<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('aspirasis', function (Blueprint $table) {
            $table->string('nisn', 20)->nullable()->after('user_id');
            $table->string('kelas', 50)->nullable()->after('nisn');
        });
    }

    public function down()
    {
        Schema::table('aspirasis', function (Blueprint $table) {
            $table->dropColumn(['nisn', 'kelas']);
        });
    }
};