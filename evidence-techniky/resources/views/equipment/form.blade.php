<!-- Název zařízení -->
<div class="mb-3">
    <label class="form-label">Název zařízení</label>
    <input type="text" name="name" class="form-control"
           value="{{ old('name', $equipment->name ?? '') }}"
           required maxlength="255">
</div>

<!-- Jedinečné evidenční číslo -->
<div class="mb-3">
    <label class="form-label">Evidenční číslo</label>
    <input type="text" name="inventory_number" class="form-control"
           value="{{ old('inventory_number', $equipment->inventory_number ?? '') }}"
           required maxlength="100">
</div>

<!-- Výběr stavu zařízení -->
<div class="mb-3">
    <label class="form-label">Stav zařízení</label>

    <select name="status" class="form-select" required>
        @php
            // Při úpravě načteme uložený stav zařízení
            $selectedStatus = old('status', $equipment->status ?? 'active');
        @endphp

        <option value="active" @selected($selectedStatus === 'active')>
            Aktivní
        </option>
        <option value="service" @selected($selectedStatus === 'service')>
            V servisu
        </option>
        <option value="retired" @selected($selectedStatus === 'retired')>
            Vyřazené
        </option>
    </select>
</div>

<!-- Datum nákupu -->
<div class="mb-3">
    <label class="form-label">Datum nákupu</label>
    <input type="date" name="purchased_at" class="form-control"
           value="{{ old('purchased_at', $equipment->purchased_at ?? '') }}"
           required>
</div>

<!-- Uložení formuláře -->
<button type="submit" class="btn btn-success">
    Uložit
</button>

<a href="{{ route('equipment.index') }}" class="btn btn-secondary">
    Zpět
</a>
