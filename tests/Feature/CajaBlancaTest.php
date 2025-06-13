<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Canje;
use App\Models\Residuo;
use Tests\TestCase;

class UserModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function puede_crear_usuario_y_guardar_correctamente()
    {
        $user = User::create([
            'DNI' => 12345678,
            'name' => 'Juan',
            'apellido_paterno' => 'Espinoza',
            'apellido_materno' => 'Zárate',
            'direccion' => 'Calle Principal 123',
            'Celular' => 987654321,
            'email' => 'juan@correo.com',
            'password' => bcrypt('clave123'),
            'Puntos' => 0,
            'rol' => 'usuario'
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'juan@correo.com',
            'DNI' => 12345678,
            'rol' => 'usuario'
        ]);
    }

    /** @test */
    public function usuario_puede_tener_canjes_asociados()
    {
        $user = User::factory()->create([
            'DNI' => 87654321
        ]);

        $user->canjes()->create([
            'CodRecom' => 1,
            'fecha_canje' => now(),
        ]);

        $this->assertCount(1, $user->canjes);
    }

    /** @test */
    public function usuario_puede_tener_residuos_asociados()
    {
        $user = User::factory()->create();

        $user->residuos()->create([
            'tipo' => 'papel_carton',
            'cantidad_kg' => 5
        ]);

        $this->assertCount(1, $user->residuos);
        $this->assertEquals('papel_carton', $user->residuos->first()->tipo);
    }

    /** @test */
    public function campos_ocultos_no_se_exponen_en_array()
    {
        $user = User::factory()->create([
            'password' => bcrypt('secreto'),
        ]);

        $userArray = $user->toArray();

        $this->assertArrayNotHasKey('password', $userArray);
        $this->assertArrayNotHasKey('remember_token', $userArray);
    }

    /** @test */
    public function atributos_casts_funcionan_correctamente()
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
            'Puntos' => 10,
        ]);

        $this->assertInstanceOf(\Illuminate\Support\Carbon::class, $user->email_verified_at);
        $this->assertIsInt($user->Puntos);
    }
}
