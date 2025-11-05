
{{-- === CATEGORÍAS DE TRABAJO === --}}
<div>
    <label class="block text-sm font-medium mb-2">Categorías de trabajo de interés:</label>
    <div class="grid grid-cols-2 md:grid-cols-5 gap-2">
        @foreach ($categories as $category)
            <label class="inline-flex items-center space-x-2">
                <input type="checkbox" name="work_categories[]" value="{{ $category }}"
                       @if (in_array($category, $profile->work_categories ?? [])) checked @endif
                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                <span>{{ $category }}</span>
            </label>
        @endforeach
    </div>
</div>

{{-- === BIO Y EXPERIENCIA === --}}
<div>
    <x-input-label for="bio" :value="'Descripción personal *'" />
    <textarea name="bio" id="bio" rows="3"
              class="w-full rounded-xl border border-gray-300 focus:border-indigo-400 focus:ring focus:ring-indigo-200 transition-shadow" required>{{ old('bio', $profile->bio) }}</textarea>
    <x-input-error :messages="$errors->get('bio')" />
</div>

<div>
    <x-input-label for="experience" :value="'Experiencia laboral *'" />
    <textarea name="experience" id="experience" rows="4"
              class="w-full rounded-xl border border-gray-300 focus:border-indigo-400 focus:ring focus:ring-indigo-200 transition-shadow" required>{{ old('experience', $profile->experience) }}</textarea>
    <x-input-error :messages="$errors->get('experience')" />
</div>

{{-- === UBICACIÓN === --}}
<div class="grid grid-cols-2 md:grid-cols-5 gap-4">
    <div>
        <x-input-label for="department" :value="'Departamento *'" />
        <x-text-input name="department" id="department" type="text"
                      :readonly="!$isEditable"
                      class="w-full {{ !$isEditable ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                      :value="old('department', $profile->department)" required />
    </div>
    <div>
        <x-input-label for="municipality" :value="'Municipio *'" />
        <x-text-input name="municipality" id="municipality" type="text"
                      :readonly="!$isEditable"
                      class="w-full {{ !$isEditable ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                      :value="old('municipality', $profile->municipality)" required />
    </div>
    <div>
        <x-input-label for="zone" :value="'Zona'" />
        <x-text-input name="zone" id="zone" type="text"
                      :readonly="!$isEditable"
                      class="w-full {{ !$isEditable ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                      :value="old('zone', $profile->zone)" />
    </div>
    <div>
        <x-input-label for="neighborhood" :value="'Colonia / Aldea / Barrio'" />
        <x-text-input name="neighborhood" id="neighborhood" type="text"
                      :readonly="!$isEditable"
                      class="w-full {{ !$isEditable ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                      :value="old('neighborhood', $profile->neighborhood)" />
    </div>
    <div>
        <x-input-label for="phone" :value="'Teléfono'" />
        <x-text-input name="phone" id="phone" type="text"
                      class="w-full"
                      :value="old('phone', $user->phone)" />
    </div>
</div>

{{-- === NACIMIENTO Y GÉNERO === --}}
<div class="grid grid-cols-1 md:grid-cols-5 gap-6">
    <div>
        <x-input-label for="birth_date" :value="'Fecha de nacimiento *'" />
        <x-text-input type="date" name="birth_date" id="birth_date"
                      :readonly="!$isEditable"
                      class="w-full {{ !$isEditable ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                      value="{{ old('birth_date', $profile->birth_date ? \Carbon\Carbon::parse($profile->birth_date)->format('Y-m-d') : '') }}" required />
        <x-input-error :messages="$errors->get('birth_date')" />
    </div>

    <div>
        <x-input-label for="gender" :value="'Género *'" />
        <select name="gender" id="gender"
                class="w-full rounded-xl border border-gray-300 focus:border-indigo-400"
            {{ !$isEditable ? 'disabled' : '' }}>
            <option value="">Seleccione</option>
            <option value="male" @selected(old('gender', $profile->gender) === 'male')>Masculino</option>
            <option value="female" @selected(old('gender', $profile->gender) === 'female')>Femenino</option>
            <option value="other" @selected(old('gender', $profile->gender) === 'other')>Otro</option>
        </select>
        <x-input-error :messages="$errors->get('gender')" />
    </div>
</div>
