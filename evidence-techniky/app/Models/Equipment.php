<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    // Název tabulky v databázi
    protected $table = 'equipment';

    // Údaje, které můžeme ukládat a upravovat
    protected $fillable = [
        'name',
        'inventory_number',
        'status',
        'purchased_at',
    ];

    // Jedno zařízení může mít více servisních záznamů
    public function serviceRecords()
    {
        return $this->hasMany(ServiceRecord::class);
    }
}
