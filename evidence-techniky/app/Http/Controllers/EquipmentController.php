<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EquipmentController extends Controller
{
    // Zobrazí seznam všech zařízení
    public function index(Request $request)
    {
        // Načteme filtr podle stavu
        $status = $request->query('status');

        // Vytvoříme dotaz na zařízení
        $query = Equipment::query();

        // Pokud je vybraný platný stav, filtrujeme
        if (in_array($status, ['active', 'service', 'retired'], true)) {
            $query->where('status', $status);
        }

        // Seřadíme zařízení od nejnovějších
        $equipment = $query->latest()->get();

        return view('equipment.index', compact('equipment', 'status'));
    }

    // Zobrazí formulář pro nové zařízení
    public function create()
    {
        return view('equipment.create');
    }

    // Uloží nové zařízení do databáze
    public function store(Request $request)
    {
        // Zkontrolujeme vyplněné údaje
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'inventory_number' => 'required|string|max:100|unique:equipment,inventory_number',
            'status' => 'required|in:active,service,retired',
            'purchased_at' => 'required|date_format:Y-m-d',
        ]);

        // Vytvoříme nové zařízení
        Equipment::create($data);

        return redirect()->route('equipment.index')
            ->with('success', 'Zařízení bylo přidáno.');
    }

    // Zobrazí detail zařízení a servisní historii
    public function show(Equipment $equipment)
    {
        // Načteme servisní záznamy
        $equipment->load([
            'serviceRecords' => function ($query) {
                $query->orderByDesc('serviced_at');
            }
        ]);

        // Spočítáme celkové servisní náklady
        $totalCost = $equipment->serviceRecords()->sum('cost');

        return view('equipment.show', compact('equipment', 'totalCost'));
    }

    // Zobrazí formulář pro úpravu zařízení
    public function edit(Equipment $equipment)
    {
        return view('equipment.edit', compact('equipment'));
    }

    // Uloží změny existujícího zařízení
    public function update(Request $request, Equipment $equipment)
    {
        // Evidenční číslo musí být jedinečné
        // Při úpravě ale ignorujeme aktuální zařízení
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'inventory_number' => [
                'required',
                'string',
                'max:100',
                Rule::unique('equipment', 'inventory_number')->ignore($equipment->id),
            ],
            'status' => 'required|in:active,service,retired',
            'purchased_at' => 'required|date_format:Y-m-d',
        ]);

        // Aktualizujeme zařízení v databázi
        $equipment->update($data);

        return redirect()->route('equipment.index')
            ->with('success', 'Zařízení bylo upraveno.');
    }

    // Smaže zařízení z databáze
    public function destroy(Equipment $equipment)
    {
        // Díky cascadeOnDelete se smažou i servisní záznamy
        $equipment->delete();

        return redirect()->route('equipment.index')
            ->with('success', 'Zařízení bylo smazáno.');
    }
}
