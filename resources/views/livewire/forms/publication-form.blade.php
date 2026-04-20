<div>
    @if(!$submitted)
        <form wire:submit="submit" class="datos-descarga-form">
            <div class="text-center">
                <h3>Gracias por tu interés en nuestras publicaciones.</h3>
                <h4>Déjanos tus datos para mantenernos en contacto</h4>
            </div>

            @if (session()->has('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" wire:model.live="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror">
                @error('nombre')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Correo electrónico:</label>
                <input type="email" wire:model.live="email" id="email" class="form-control @error('email') is-invalid @enderror">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="telefono">Teléfono:</label>
                <input type="text" wire:model.live="telefono" id="telefono" class="form-control @error('telefono') is-invalid @enderror">
                @error('telefono')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="organizacion">Organización:</label>
                <input type="text" wire:model.live="organizacion" id="organizacion" class="form-control @error('organizacion') is-invalid @enderror">
                @error('organizacion')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group text-right mt-3">
                <button type="submit" class="btn btn-enviar" wire:loading.attr="disabled">
                    <span wire:loading.remove>Enviar</span>
                    <span wire:loading>Enviando...</span>
                </button>
            </div>
        </form>
    @else
        <div class="formulario-gracias">
            <h3>Tus datos han sido enviados correctamente.</h3>
        </div>
    @endif
</div>
