<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;


class PruebasTest extends TestCase
{
    //Prueba Unitaras- Metodo ver Carreras
    // public function test_ver_carreras()
    // {
    //     $user = User::Factory() -> make([
    //         'role_id' => 2
    //     ]);
    //     $request = $this->actingAs($user)->get('/api/v1/carreras/adminE');
    //     $request -> assertStatus(200);
    // }

    // public function test_ver_semestres()
    // {
    //     $user = User::Factory() -> make([
    //         'role_id' => 2
    //     ]);
    //     $request = $this->actingAs($user)->get('/api/v1/semestres/admin');
    //     $request -> assertStatus(200);
    // }

    public function test_ver_materias()
    {
        $user = User::Factory() -> make([
            'role_id' => 2
        ]);
        $request = $this->actingAs($user)->get('/api/v1/materias/adminE');
        $request -> assertStatus(200);
    }

    // public function test_ver_documentos()
    // {
    //     $user = User::Factory() -> make([
    //         'role_id' => 2
    //     ]);
    //     $request = $this->actingAs($user)->get('/api/v1/documentos/admin');
    //     $request -> assertStatus(200);
    // }
     
    // //Gestion Comentarios
    public function test_ver_comentarios()
    {
        $user = User::Factory() -> make([
            'role_id' => 2
        ]);
        $request = $this->actingAs($user)->get('/api/v1/comentarios/sistema');
        $request -> assertStatus(200);
    }
    public function test_crear_comentarios()
    {
        $user = User::where('id', 9)->first();
        $comentario = [
            "comentario" => "Este es un ejemplo de comentario",
        ];
        $request = $this->actingAs($user)->post(sprintf('/api/v1/comentarios/sistema/cambio/%u/',2), $comentario);
        $request -> assertStatus(200);
    }

    public function test_actualizar_comentarios()
    {
        $user = User::where('id', 9)->first();
        $comentario = [
            "comentario" => "Este es una ejemplo de actualizacion",
        ];
        $request = $this->actingAs($user)->post(sprintf('/api/v1/comentarios/sistema/actualizar/%u/',7), $comentario);
        $request -> assertStatus(200);
    }
    public function test_eliminar_comentarios()
    {
        $user = User::where('id', 9)->first();
        $request = $this->actingAs($user)->delete(sprintf('/api/v1/comentarios/sistema/%u/',11));
        $request -> assertStatus(200);
    }

}
