<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained('leads')->cascadeOnDelete();
            $table->decimal('sale_value', 15, 2);
            $table->decimal('split_percent', 5, 2);
            $table->decimal('revenue_broker', 15, 2);
            $table->timestamps();

            $table->unique('lead_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
