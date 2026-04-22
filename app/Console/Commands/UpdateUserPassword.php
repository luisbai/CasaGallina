<?php

namespace App\Console\Commands;

use App\Modules\User\Infrastructure\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class UpdateUserPassword extends Command
{
    protected $signature = 'user:update-password {email : Email del usuario} {--password= : Nueva contraseña (opcional, se pedirá si no se proporciona)}';

    protected $description = 'Actualiza la contraseña de un usuario';

    public function handle(): int
    {
        $email = $this->argument('email');
        $password = $this->option('password');

        // Buscar el usuario
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("No se encontró un usuario con el email: {$email}");
            return self::FAILURE;
        }

        // Si no se proporcionó la contraseña como opción, pedirla de forma interactiva
        if (!$password) {
            $password = $this->secret('Ingresa la nueva contraseña:');
            $passwordConfirmation = $this->secret('Confirma la nueva contraseña:');

            if ($password !== $passwordConfirmation) {
                $this->error('Las contraseñas no coinciden.');
                return self::FAILURE;
            }

            if (empty($password)) {
                $this->error('La contraseña no puede estar vacía.');
                return self::FAILURE;
            }
        }

        try {
            // Actualizar la contraseña
            $user->password = Hash::make($password);
            $user->save();

            $this->info("✓ Contraseña actualizada exitosamente para el usuario: {$user->name} ({$user->email})");
            
            return self::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Error al actualizar la contraseña: ' . $e->getMessage());
            return self::FAILURE;
        }
    }
}

