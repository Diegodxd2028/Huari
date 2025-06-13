<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Recompensa;

class RecompensasControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function usuario_autenticado_puede_ver_recompensas()
    {
        $usuario = User::factory()->create([
            'DNI' => 12345678,
            'name' => 'Juan',
            'apellido_paterno' => 'Espinoza',
            'apellido_materno' => 'Zarate',
            'direccion' => 'Av. Perú',
            'Celular' => 987654321,
            'email' => 'user@correo.com',
            'password' => bcrypt('password'),
            'rol' => 'usuario',
            'Puntos' => 100,
        ]);

        $response = $this->actingAs($usuario)->get('/recompensas');

        $response->assertStatus(200);
        $response->assertViewIs('recompensas');
    }

    /** @test */
    public function admin_puede_ver_formulario_creacion_de_recompensas()
    {
        $admin = User::factory()->create([
            'DNI' => 87654321,
            'name' => 'Admin',
            'apellido_paterno' => 'Perez',
            'apellido_materno' => 'Lopez',
            'direccion' => 'Jr. Central',
            'Celular' => 999999999,
            'email' => 'admin@correo.com',
            'password' => bcrypt('adminpass'),
            'rol' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get('/admin/recompensas/create');

        $response->assertStatus(200);
        $response->assertViewIs('admin.recompensas');
    }

    /** @test */
    public function admin_puede_guardar_una_nueva_recompensa()
    {
        $admin = User::factory()->create([
            'DNI' => 99999999,
            'name' => 'Admin',
            'apellido_paterno' => 'Vega',
            'apellido_materno' => 'Torres',
            'direccion' => 'Mz. A Lote 2',
            'Celular' => 912345678,
            'email' => 'admin@correo.com',
            'password' => bcrypt('adminpass'),
            'rol' => 'admin',
        ]);

        $data = [
            'Titulo' => 'Bolsa ecológica',
            'Descripcion' => 'Bolsa hecha de material reciclado',
            'PuntosNecesarios' => 50,
            'EsTemporal' => false,
            'Stock' => 100,
        ];

        $response = $this->actingAs($admin)->post('/admin/recompensas', $data);

        $response->assertRedirect(route('admin.recompensas.create'));
        $this->assertDatabaseHas('recompensas', ['Titulo' => 'Bolsa ecológica']);
    }
}
