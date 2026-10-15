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
        // Získáme vybraný filtr podle stavu
        $status = $request->query('status');

        // Připravíme dotaz a rovnou načteme součet servisních nákladů
        $query = Equipment::withSum('serviceRecords', 'cost');

        // Pokud je vybraný platný stav, aplikujeme filtr
        if (in_array($status, ['active', 'service', 'retired'], true)) {
            $query->where('status', $status);
        }

        // Načteme zařízení od nejnovějších
        $equipment = $query->latest()->get();

        return view('equipment.index', compact('equipment', 'status'));
    }

    // Formulář pro přidání zařízení
    public function create()
    {
        return view('equipment.create');
    }

    // Uložení nového zařízení
    public function store(Request $request)
    {
        $data = $request->validate([
            // Název zařízení
            'name' => 'required|string|max:255',

            // Evidenční číslo musí být povinné, jedinečné a pouze čísla
            'inventory_number' => [
                'required',
                'string',
                'max:50',
                'unique:equipment,inventory_number',
                'regex:/^[0-9]+$/',
            ],

            // Povolené stavy
            'status' => 'required|in:active,service,retired',

            // Datum nákupu musí být platné a nesmí být v budoucnosti
            'purchased_at' => 'required|date_format:Y-m-d|before_or_equal:today',
        ], [
            // Vlastní chybové hlášky
            'inventory_number.regex' => 'Evidenční číslo může obsahovat pouze čísla.',
            'inventory_number.unique' => 'Toto evidenční číslo už existuje.',
        ]);

        // Vytvoříme nové zařízení
        Equipment::create($data);

        return redirect()->route('equipment.index')
            ->with('success', 'Zařízení bylo úspěšně přidáno.');
    }

    // Detail zařízení
    public function show(Equipment $equipment)
    {
        // Načteme servisní historii od nejnovějších
        $equipment->load([
            'serviceRecords' => function ($query) {
                $query->orderByDesc('serviced_at');
            }
        ]);

        // Spočítáme celkové servisní náklady
        $totalCost = $equipment->serviceRecords()->sum('cost');

        return view('equipment.show', compact('equipment', 'totalCost'));
    }

    // Formulář pro úpravu zařízení
    public function edit(Equipment $equipment)
    {
        return view('equipment.edit', compact('equipment'));
    }

    // Uložení úprav zařízení
    public function update(Request $request, Equipment $equipment)
    {
        $data = $request->validate([
            // Název zařízení
            'name' => 'required|string|max:255',

            // Evidenční číslo musí být jedinečné a pouze číselné
            'inventory_number' => [
                'required',
                'string',
                'max:50',
                Rule::unique('equipment', 'inventory_number')->ignore($equipment->id),
                'regex:/^[0-9]+$/',
            ],

            // Povolené stavy
            'status' => 'required|in:active,service,retired',

            // Datum nákupu
            'purchased_at' => 'required|date_format:Y-m-d|before_or_equal:today',
        ], [
            // Vlastní chybové hlášky
            'inventory_number.regex' => 'Evidenční číslo může obsahovat pouze čísla.',
            'inventory_number.unique' => 'Toto evidenční číslo už existuje.',
        ]);

        // Uložíme změny
        $equipment->update($data);

        return redirect()->route('equipment.index')
            ->with('success', 'Zařízení bylo úspěšně upraveno.');
    }

    // Smazání zařízení
    public function destroy(Equipment $equipment)
    {
        $equipment->delete();

        return redirect()->route('equipment.index')
            ->with('success', 'Zařízení bylo úspěšně smazáno.');
    }
}
