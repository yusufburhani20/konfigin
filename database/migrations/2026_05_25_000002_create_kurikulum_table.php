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
        Schema::create('kurikulum', function (Blueprint $table) {
            $table->id();
            $table->string('nama_mapel', 200);
            $table->string('modul_url', 500)->default('#');
            $table->string('roadmap_url', 500)->default('#');
            $table->string('harga', 100)->nullable();
            $table->text('fitur')->nullable();
            $table->string('badge', 50)->nullable();
            $table->integer('urutan')->default(0);
            $table->boolean('aktif')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kurikulum');
    }
};
