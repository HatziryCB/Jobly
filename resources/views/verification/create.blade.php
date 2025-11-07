@extends('layouts.guest')
@section('title', 'Verificación de identidad - Jobly')

@section('content')
    <div class="min-h-3.5 flex justify-center bg-gray-50 ">
        <div class="bg-white shadow-xl rounded-3xl overflow-hidden w-full max-w-5xl">
            <div class="grid grid-cols-1 md:grid-cols-2">
                {{-- Imagen lateral --}}
                <div class="hidden md:block">
                    <img src="https://www.logalty.com/wp-content/uploads/2024/07/very-id.png"
                         alt="Verificación de identidad"
                         class="w-full h-full object-cover">
                </div>

                {{-- Formulario --}}
                <div class="p-10">
                    <h2 class="text-2xl font-bold mb-2 text-center text-gray-800">Verificación de identidad</h2>
                    <p class="text-sm text-gray-600 text-center mb-8">
                        Sube tus documentos oficiales. Solo podrás enviar una solicitud si no tienes otra en revisión.
                    </p>

                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                            <strong>Errores:</strong>
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('verification.store') }}" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        {{-- DPI --}}
                        <div>
                            <x-input-label for="dpi" value="DPI *" />
                            <x-text-input
                                id="dpi"
                                name="dpi"
                                inputmode="numeric"
                                maxlength="13"
                                placeholder="#### ##### ####"
                                class="w-full rounded-xl border border-gray-300 focus:border-indigo-400 focus:ring focus:ring-indigo-200 transition-shadow text-base"
                                value="{{ old('dpi') }}"
                                required
                            />

                        </div>

                        {{-- DOCUMENTOS --}}
                        <div class="border-t pt-4">
                            <h3 class="text-md font-semibold mb-4 text-gray-700">Carga de documentos</h3>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                {{-- DPI frente --}}
                                <div>
                                    <x-input-label for="dpi_front" value="DPI (frente) *" />
                                    <input type="file" name="dpi_front" accept="image/*" required
                                           class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm focus:ring-[var(--brand-secondary)] focus:border-[var(--brand-secondary)]">
                                </div>

                                {{-- Selfie --}}
                                <div>
                                    <x-input-label for="selfie" value="Selfie con DPI *" />
                                    <input type="file" name="selfie" accept="image/*" required
                                           class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm focus:ring-[var(--brand-secondary)] focus:border-[var(--brand-secondary)]">
                                </div>

                                {{-- Comprobante --}}
                                <div class="col-span-2">
                                    <x-input-label for="voucher" value="Comprobante de residencia (opcional)" />
                                    <input type="file" name="voucher" accept="image/*,application/pdf"
                                           class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm focus:ring-[var(--brand-secondary)] focus:border-[var(--brand-secondary)]">
                                    <p class="text-xs text-gray-500 mt-1">
                                        Si lo agregas, podrás obtener la verificación completa (identidad + ubicación).
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- BOTONES --}}
                        <div class="flex justify-end gap-3 mt-4">
                            <button type="button" onclick="window.history.back()"
                                    class="rounded-xl px-4 py-2.5 bg-gray-200 text-gray-700 hover:bg-gray-300 transition">
                                Cancelar
                            </button>
                            <button type="submit"
                                    onclick="return confirm('¿Confirmas que tus datos son correctos y deseas enviar la solicitud?')"
                                    class="rounded-xl px-4 py-2.5 bg-[var(--brand-primary)] text-white hover:bg-[var(--brand-secondary)] transition">
                                Enviar solicitud
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- Máscara para DPI --}}
<script>
    const dpi = document.getElementById('dpi');
    if (dpi) {
        dpi.addEventListener('input', () => {
            const digits = dpi.value.replace(/\D/g, '').slice(0, 13);
            let formatted = '';
            if (digits.length <= 4) formatted = digits;
            else if (digits.length <= 9) formatted = digits.slice(0,4) + ' ' + digits.slice(4);
            else formatted = digits.slice(0,4) + ' ' + digits.slice(4,9) + ' ' + digits.slice(9);
            dpi.value = formatted;
        });
    }
</script>

