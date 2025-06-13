<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CajaNegraTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function login_fails_with_invalid_credentials()
    {
        $response = $this->post('/login/usuario', [
            'email' => 'fake@correo.com',
            'password' => 'incorrecto',
        ]);

        $response->assertSessionHas('error', 'Credenciales incorrectas o no tiene rol de usuario.');
        $this->assertGuest();
    }

    /** @test */
    public function login_succeeds_with_valid_credentials()
    {
        $user = User::factory()->create([
            'DNI' => 12345678,
            'apellido_paterno' => 'Ruiz',
            'apellido_materno' => 'Soto',
            'direccion' => 'Calle Falsa',
            'Celular' => 987654321,
            'email' => 'usuario@correo.com',
            'password' => Hash::make('password123'),
            'rol' => 'usuario',
        ]);

        $response = $this->post('/login/usuario', [
            'email' => 'usuario@correo.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('inicio'));
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function register_succeeds_with_valid_data()
    {
        $response = $this->post('/register', [
            'DNI' => 12345679,
            'name' => 'Nuevo Usuario',
            'apellido_paterno' => 'López',
            'apellido_materno' => 'García',
            'direccion' => 'Av. Principal 123',
            'Celular' => 987654322,
            'email' => 'nuevo@correo.com',
            'password' => 'clave1234',
            'password_confirmation' => 'clave1234',
        ]);

        $response->assertRedirect(route('inicio'));
        $this->assertDatabaseHas('users', ['email' => 'nuevo@correo.com']);
        $this->assertAuthenticated();
    }

    /** @test */
    public function register_fails_with_invalid_email()
    {
        $response = $this->post('/register', [
            'DNI' => 12345680,
            'name' => 'Juan',
            'apellido_paterno' => 'Peralta',
            'apellido_materno' => 'Morales',
            'direccion' => 'Av. Sur',
            'Celular' => 987654323,
            'email' => 'correo-no-valido',
            'password' => 'clave1234',
            'password_confirmation' => 'clave1234',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }
}
