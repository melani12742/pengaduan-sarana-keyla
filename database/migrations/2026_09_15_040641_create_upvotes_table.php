<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('upvotes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aspirasi_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->unique(['aspirasi_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('upvotes');
    }
};