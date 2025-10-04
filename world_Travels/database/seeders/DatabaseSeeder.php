<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Departamentos;
use App\Models\Municipios;
use App\Models\Categorias_Actividades;
use App\Models\Actividades;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test' . time() . '@example.com',
        ]);

        // Crear usuario en la tabla usuarios
        $usuario = \App\Models\Usuarios::create([
            'Nombre' => 'Admin',
            'Apellido' => 'Sistema',
            'Email' => 'admin@example.com',
            'Contraseña' => bcrypt('password'),
            'Telefono' => '123456789',
            'Nacionalidad' => 'Colombia',
            'Rol' => 'administrador'
        ]);

        // Crear departamento de Boyacá
        $boyaca = Departamentos::create([
            'nombre_departamento' => 'Boyacá'
        ]);

        // Crear municipios
        $tunja = Municipios::create([
            'Nombre_Municipio' => 'Tunja',
            'idDepartamento' => $boyaca->id
        ]);

        $villaDeLeyva = Municipios::create([
            'Nombre_Municipio' => 'Villa de Leyva',
            'idDepartamento' => $boyaca->id
        ]);

        $sogamoso = Municipios::create([
            'Nombre_Municipio' => 'Sogamoso',
            'idDepartamento' => $boyaca->id
        ]);

        // Crear categorías
        $cultura = Categorias_Actividades::create([
            'nombre_categoria' => 'Cultural'
        ]);

        $naturaleza = Categorias_Actividades::create([
            'nombre_categoria' => 'Naturaleza'
        ]);

        $aventura = Categorias_Actividades::create([
            'nombre_categoria' => 'Aventura'
        ]);

        // Crear actividades
        Actividades::create([
            'Nombre_Actividad' => 'Visita al Museo Casa del Fundador',
            'Descripcion' => 'Explora la historia de Colombia en este museo ubicado en el corazón de Tunja.',
            'Fecha_Actividad' => now()->addDays(7)->toDateString(),
            'Hora_Actividad' => '10:00:00',
            'Precio' => 15000,
            'Cupo_Maximo' => 20,
            'Ubicacion' => 'Tunja, Boyacá',
            'Imagen' => 'https://via.placeholder.com/400x250?text=Museo+Casa+del+Fundador',
            'idCategoria' => $cultura->id,
            'idMunicipio' => $tunja->id,
            'idUsuario' => $usuario->id
        ]);

        Actividades::create([
            'Nombre_Actividad' => 'Paseo por Villa de Leyva',
            'Descripcion' => 'Recorre las calles empedradas y plazas coloniales de este pueblo mágico.',
            'Fecha_Actividad' => now()->addDays(10)->toDateString(),
            'Hora_Actividad' => '09:00:00',
            'Precio' => 25000,
            'Cupo_Maximo' => 15,
            'Ubicacion' => 'Villa de Leyva, Boyacá',
            'Imagen' => 'https://via.placeholder.com/400x250?text=Villa+de+Leyva',
            'idCategoria' => $cultura->id,
            'idMunicipio' => $villaDeLeyva->id,
            'idUsuario' => $usuario->id
        ]);

        Actividades::create([
            'Nombre_Actividad' => 'Baños Termales en Sogamoso',
            'Descripcion' => 'Relájate en las aguas medicinales de los termales de Sogamoso.',
            'Fecha_Actividad' => now()->addDays(5)->toDateString(),
            'Hora_Actividad' => '14:00:00',
            'Precio' => 30000,
            'Cupo_Maximo' => 25,
            'Ubicacion' => 'Sogamoso, Boyacá',
            'Imagen' => 'https://via.placeholder.com/400x250?text=Baños+Termales',
            'idCategoria' => $naturaleza->id,
            'idMunicipio' => $sogamoso->id,
            'idUsuario' => $usuario->id
        ]);

        Actividades::create([
            'Nombre_Actividad' => 'Senderismo en el Parque Nacional Pisba',
            'Descripcion' => 'Aventura en la naturaleza con vistas espectaculares de los Andes.',
            'Fecha_Actividad' => now()->addDays(14)->toDateString(),
            'Hora_Actividad' => '08:00:00',
            'Precio' => 45000,
            'Cupo_Maximo' => 12,
            'Ubicacion' => 'Sogamoso, Boyacá',
            'Imagen' => 'https://via.placeholder.com/400x250?text=Parque+Pisba',
            'idCategoria' => $aventura->id,
            'idMunicipio' => $sogamoso->id,
            'idUsuario' => $usuario->id
        ]);
    }
}
