<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\Level;
use App\Models\User;
use App\Models\Profile;
use App\Models\Location;
use App\Models\Image;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Post;
use App\Models\Video;
use App\Models\Comment;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear 3 instancias del modelo Group
        Group::factory()->count(3)->create();

        // Crear 3 instancias del modelo Level con el nombre 'Oro'
        Level::factory()->count(3)->create(['name' => 'Oro']);
        
        // Crear 3 instancias del modelo Level con el nombre 'Plata'
        Level::factory()->count(3)->create(['name' => 'Plata']);
        
        // Crear 3 instancias del modelo Level con el nombre 'Bronce'
        Level::factory()->count(3)->create(['name' => 'Bronce']);

        // Crear 5 instancias del modelo User y asociarles perfiles, ubicaciones e imágenes
        User::factory()->count(5)->create()->each(function ($user) {
            // Crear el perfil y asignar el user_id correctamente
            $profile = Profile::factory()->create(['user_id' => $user->id]);
            $user->profile()->save($profile);

            // Asignar una ubicación al perfil y asociar el profile_id
            $location = Location::factory()->create(['profile_id' => $profile->id]);
            $profile->location()->save($location);

            // Asociar el usuario a grupos aleatorios
            $user->groups()->attach($this->array(rand(1, 3)));

            // Crear una imagen asociada al usuario
            Image::factory()->create([
                'url' => 'https://lorempixel.com/90/90/',
                'imageable_type' => User::class,
                'imageable_id' => $user->id,
            ]);
        });

        // Crear 4 categorías
        Category::factory()->count(4)->create();

        // Crear 12 etiquetas
        Tag::factory()->count(12)->create();

        // Crear 40 publicaciones y asociarles imágenes, etiquetas y comentarios
        Post::factory()->count(40)->create()->each(function ($post) {
            Image::factory()->create([
                'imageable_type' => Post::class,
                'imageable_id' => $post->id,
            ]);
            $post->tags()->attach($this->array(rand(1, 12)));

            $number_comments = rand(1, 6);
            for ($i = 0; $i < $number_comments; $i++) {
                $post->comments()->save(Comment::factory()->make());
            }
        });

        // Crear 40 videos y asociarles imágenes, etiquetas y comentarios
        Video::factory()->count(40)->create()->each(function ($video) {
            Image::factory()->create([
                'imageable_type' => Video::class,
                'imageable_id' => $video->id,
            ]);
            $video->tags()->attach($this->array(rand(1, 12)));

            $number_comments = rand(1, 6);
            for ($i = 0; $i < $number_comments; $i++) {
                $video->comments()->save(Comment::factory()->make());
            }
        });
    }

    /**
     * Genera un array de enteros desde 1 hasta el valor máximo proporcionado.
     *
     * @param int $max
     * @return array<int>
     */
    public function array(int $max): array
    {
        return range(1, $max);
    }
}