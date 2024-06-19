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
        Schema::create('sales', function (Blueprint $table) {
          $table->id();
            $table->string('owner')->constrained('businesses')->onDelete('cascade');
            $table->string('item_name');
            $table->integer('quantity');
            $table->decimal('sale_price', 10, 2);
            $table->decimal('total_price', 10, 2);
            $table->decimal('total_profit', 10, 2)->nullable();
            $table->date('date_of_transaction');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
