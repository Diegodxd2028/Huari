<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;

class AuthIntegrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_user_login_integration()
    {
        $user = User::factory()->create([
            'DNI' => 12345678,
            'apellido_paterno' => 'Perez',
            'apellido_materno' => 'Gomez',
            'direccion' => 'Jr. Principal 123',
            'Celular' => 987654321,
            'rol' => 'usuario',
            'email' => 'test@correo.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->post('/login/usuario', [
            'email' => 'test@correo.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('inicio'));
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function test_user_can_register_successfully()
    {
        $response = $this->post('/register', [
            'DNI' => 87654321,
            'name' => 'Juan Test',
            'apellido_paterno' => 'Lopez',
            'apellido_materno' => 'Vera',
            'direccion' => 'Av. Central 456',
            'Celular' => 987654322,
            'email' => 'juan@example.com',
            'password' => 'testpassword',
            'password_confirmation' => 'testpassword',
        ]);

        $response->assertRedirect(route('inicio'));
        $this->assertDatabaseHas('users', ['email' => 'juan@example.com']);
        $this->assertAuthenticated();
    }

    /** @test */
    public function test_registration_fails_with_unmatched_passwords()
    {
        $response = $this->post('/register', [
            'DNI' => 87654322,
            'name' => 'Carlos',
            'apellido_paterno' => 'Ramos',
            'apellido_materno' => 'Silva',
            'direccion' => 'Av. Norte',
            'Celular' => 987654323,
            'email' => 'carlos@example.com',
            'password' => '12345678',
            'password_confirmation' => '123456789',
        ]);

        $response->assertSessionHasErrors('password');
        $this->assertGuest();
    }

    /** @test */
    public function test_login_fails_with_invalid_credentials()
    {
        User::factory()->create([
            'DNI' => 12345679,
            'apellido_paterno' => 'Ruiz',
            'apellido_materno' => 'Soto',
            'direccion' => 'Calle Falsa 123',
            'Celular' => 987654324,
            'email' => 'test@correo.com',
            'password' => bcrypt('correctpassword'),
            'rol' => 'usuario',
        ]);

        $response = $this->post('/login/usuario', [
            'email' => 'test@correo.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHas('error');
        $this->assertGuest();
    }

    /** @test */
    public function test_authenticated_user_can_access_protected_route()
    {
        $user = User::factory()->create([
            'DNI' => 12345680,
            'apellido_paterno' => 'Torres',
            'apellido_materno' => 'Medina',
            'direccion' => 'Pasaje Sur',
            'Celular' => 987654325,
            'rol' => 'usuario',
        ]);

        $response = $this->actingAs($user)->get('/inicio');
        $response->assertStatus(200);
        $response->assertSee('Bienvenido');
    }
}
