<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Vytvoření tabulky pro servisní zásahy
    public function up(): void
    {
        Schema::create('service_records', function (Blueprint $table) {
            $table->id();

            // ID zařízení, ke kterému servis patří
            $table->foreignId('equipment_id')
                ->constrained('equipment')
                ->cascadeOnDelete();

            // Popis provedeného servisu
            $table->text('description');

            // Datum servisního zásahu
            $table->date('serviced_at');

            // Cena servisu, maximálně 2 desetinná místa
            $table->decimal('cost', 10, 2);

            // Datum vytvoření a úpravy záznamu
            $table->timestamps();
        });
    }

    // Smazání tabulky při vrácení migrace
    public function down(): void
    {
        Schema::dropIfExists('service_records');
    }
};
