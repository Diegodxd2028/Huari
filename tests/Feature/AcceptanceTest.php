<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AcceptanceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_login_with_valid_credentials()
    {
        $user = User::factory()->create([
            'DNI' => 12345678,
            'name' => 'Juan',
            'apellido_paterno' => 'Espinoza',
            'apellido_materno' => 'Zárate',
            'direccion' => 'Av. Los Próceres 123',
            'Celular' => 987654321,
            'email' => 'test@correo.com',
            'password' => Hash::make('password123'),
            'rol' => 'usuario',
            'Puntos' => 0,
        ]);

        $response = $this->post('/login/usuario', [
            'email' => 'test@correo.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('inicio'));
        $this->assertAuthenticatedAs($user);
    }
}
