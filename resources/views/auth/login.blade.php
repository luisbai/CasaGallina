@extends('layouts.plain')

@section('content')
<div class="bg-forest-900 h-screen flex items-center justify-center">
    <div class="mx-auto w-full max-w-md">
        <div class="mb-6 space-y-2">
            <img src="/assets/images/logo-white.png" class="h-10 mx-auto" alt="">
        </div>
        <flux:card class="space-y-6 !bg-forest-800 !border-forest-700">
            <div class="flex flex-col">
                <flux:heading size="xl" class="text-center font-medium opacity-75 !text-white">
                    Panel de Administración
                </flux:heading>
            </div>
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4 space-y-2">
                    <flux:label for="email" class="opacity-85 !text-white !text-lg font-serif">Correo Electrónico</flux:label>
                    <flux:input
                        id="email"
                        name="email"
                        type="email"
                        :value="old('email')"
                        required
                        autocomplete="email"
                        autofocus
                        class="w-full"
                    />
                    @error('email')
                        <flux:error>{{ $message }}</flux:error>
                    @enderror
                </div>

                <div class="mb-6 space-y-2">
                    <flux:label for="password" class="opacity-85 !text-white !text-lg font-serif">Contraseña</flux:label>
                    <flux:input
                        id="password"
                        name="password"
                        type="password"
                        required
                        autocomplete="current-password"
                        class="w-full"
                    />
                    @error('password')
                        <flux:error>{{ $message }}</flux:error>
                    @enderror
                </div>

                <div class="mt-4">
                    <flux:button type="submit" class="w-full !bg-forest-200 !border-forest-200 !text-forest-800 !font-serif !text-base hover:!bg-forest-300 hover:!border-forest-300">
                        Iniciar Sesión
                    </flux:button>
                </div>
            </form>
        </flux:card>
    </div>
</div>
@endsection