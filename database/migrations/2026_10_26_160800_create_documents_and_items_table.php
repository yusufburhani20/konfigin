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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['quotation', 'invoice'])->default('invoice')->index();
            $table->string('number', 50)->unique();
            $table->unsignedBigInteger('reference_id')->nullable()->index(); // ID Surat Penawaran jika ini Invoice, atau sebaliknya
            $table->unsignedBigInteger('client_id')->nullable()->index();
            $table->string('title')->nullable(); // Perihal / Judul Proyek
            $table->string('client_name');
            $table->string('client_company')->nullable();
            $table->text('client_address')->nullable();
            $table->string('client_phone')->nullable();
            $table->string('client_email')->nullable();
            $table->date('date');
            $table->date('due_date')->nullable(); // Jatuh tempo (invoice) atau berlaku hingga (quotation)
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->enum('discount_type', ['fixed', 'percent'])->default('fixed');
            $table->decimal('discount_value', 15, 2)->default(0);
            $table->decimal('discount_amount', 15, 2)->default(0);
            $table->decimal('tax_percent', 5, 2)->default(0); // misal 11%
            $table->decimal('tax_amount', 15, 2)->default(0);
            $table->decimal('total', 15, 2)->default(0);
            $table->string('status', 30)->default('draft')->index(); // quotation: draft, sent, accepted, rejected, converted; invoice: draft, unpaid, paid, cancelled
            $table->text('notes')->nullable(); // Catatan umum / Ruang lingkup
            $table->text('terms')->nullable(); // Syarat & Ketentuan
            $table->text('payment_info')->nullable(); // Rekening Bank Pembayaran
            $table->string('signer_name')->nullable(); // Nama penandatangan
            $table->string('signer_title')->nullable(); // Jabatan penandatangan
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
        });

        Schema::create('document_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_id')->constrained('documents')->onDelete('cascade');
            $table->string('item_name');
            $table->text('description')->nullable();
            $table->decimal('quantity', 10, 2)->default(1);
            $table->string('unit', 50)->default('Paket');
            $table->decimal('price', 15, 2)->default(0);
            $table->decimal('amount', 15, 2)->default(0);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_items');
        Schema::dropIfExists('documents');
    }
};
