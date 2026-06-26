<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the mutations.
     */
    public function up(): void
    {
        Schema::create('stock_mutations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('warehouse_id')->constrained()->onDelete('cascade');
            $table->integer('quantity')->comment('Positive for incoming, negative for outgoing');
            $table->string('reference_type')->comment('e.g., purchase, sales, adjustment, transfer_in, transfer_out');
            $table->unsignedBigInteger('reference_id')->nullable()->comment('ID of the reference transaction');
            $table->string('reference_number')->nullable()->comment('e.g., PO number, invoice number');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_mutations');
    }
};
