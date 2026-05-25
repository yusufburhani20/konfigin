<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('eservice', function (Blueprint $table) {
            $table->string('demo_url', 500)->nullable()->after('blog_slug')
                ->comment('URL demo aplikasi untuk tombol Demo');
        });
    }

    public function down(): void
    {
        Schema::table('eservice', function (Blueprint $table) {
            $table->dropColumn('demo_url');
        });
    }
};

