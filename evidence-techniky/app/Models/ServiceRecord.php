<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceRecord extends Model
{
    // Sloupce, které můžeme ukládat do databáze
    protected $fillable = [
        'equipment_id',
        'description',
        'serviced_at',
        'cost',
    ];

    // Jeden servisní zásah patří jednomu zařízení
    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }
}
