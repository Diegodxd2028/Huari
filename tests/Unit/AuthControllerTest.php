<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function usuario_puede_iniciar_sesion_con_credenciales_correctas()
    {
        $user = User::factory()->create([
            'DNI' => 12345678,
            'apellido_paterno' => 'Gomez',
            'apellido_materno' => 'Ramos',
            'direccion' => 'Av. Los Pinos',
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
    public function administrador_puede_iniciar_sesion_con_credenciales_correctas()
    {
        $admin = User::factory()->create([
            'DNI' => 87654321,
            'apellido_paterno' => 'Lopez',
            'apellido_materno' => 'Diaz',
            'direccion' => 'Jr. Libertad',
            'Celular' => 912345678,
            'email' => 'admin@correo.com',
            'password' => Hash::make('adminpass'),
            'rol' => 'admin',
        ]);

        $response = $this->post('/login/admin', [
            'email' => 'admin@correo.com',
            'password' => 'adminpass',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin);
    }

    /** @test */
    public function login_falla_con_rol_incorrecto()
    {
        $user = User::factory()->create([
            'DNI' => 11223344,
            'apellido_paterno' => 'Perez',
            'apellido_materno' => 'Gomez',
            'direccion' => 'Jr. Amazonas',
            'Celular' => 998877665,
            'email' => 'user@correo.com',
            'password' => Hash::make('userpass'),
            'rol' => 'usuario',
        ]);

        $response = $this->post('/login/admin', [
            'email' => 'user@correo.com',
            'password' => 'userpass',
        ]);

        $response->assertSessionHas('error');
        $this->assertGuest();
    }

    /** @test */
    public function usuario_se_registra_correctamente()
    {
        $response = $this->post('/register', [
            'DNI' => 12349876,
            'name' => 'Juan',
            'apellido_paterno' => 'Espinoza',
            'apellido_materno' => 'Zárate',
            'direccion' => 'Calle Perú',
            'Celular' => 987654321,
            'email' => 'nuevo@correo.com',
            'password' => 'nuevo1234',
            'password_confirmation' => 'nuevo1234',
        ]);

        $response->assertRedirect(route('inicio'));
        $this->assertAuthenticated();

        $this->assertDatabaseHas('users', [
            'DNI' => 12349876,
            'email' => 'nuevo@correo.com',
            'rol' => 'usuario',
        ]);
    }
}
