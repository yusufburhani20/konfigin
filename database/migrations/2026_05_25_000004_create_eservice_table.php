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
        Schema::create('eservice', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->string('url', 500);
            $table->text('deskripsi')->nullable();
            $table->string('icon', 100)->default('fas fa-globe');
            $table->string('warna', 50)->default('#0d6efd');
            $table->integer('urutan')->default(0);
            $table->boolean('aktif')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eservice');
    }
};
