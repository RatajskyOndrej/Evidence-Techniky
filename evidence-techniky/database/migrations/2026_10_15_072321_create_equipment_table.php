<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Vytvoření tabulky pro zařízení
    public function up(): void
    {
        Schema::create('equipment', function (Blueprint $table) {
            $table->id();

            // Název zařízení
            $table->string('name');

            // Jedinečné evidenční číslo
            $table->string('inventory_number')->unique();

            // Stav zařízení
            $table->enum('status', ['active', 'service', 'retired'])
                ->default('active');

            // Datum nákupu
            $table->date('purchased_at');

            // Datum vytvoření a poslední úpravy záznamu
            $table->timestamps();
        });
    }

    // Smazání tabulky při vrácení migrace
    public function down(): void
    {
        Schema::dropIfExists('equipment');
    }
};
