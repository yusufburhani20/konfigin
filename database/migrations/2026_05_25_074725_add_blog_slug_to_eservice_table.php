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
        Schema::table('eservice', function (Blueprint $table) {
            $table->string('blog_slug', 300)->nullable()->after('url')
                ->comment('Slug postingan blog untuk tombol Selengkapnya');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('eservice', function (Blueprint $table) {
            $table->dropColumn('blog_slug');
        });
    }
};

