<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //? Eliminar carpeta articles
        Storage::deleteDirectory('articles');
        Storage::deleteDirectory('categories');

        //? Crear carpeta donde se almacenaran las imagenes
        Storage::makeDirectory('articles');
        Storage::makeDirectory('categories');

        //? Llamar al seeder
        $this->call(UserSeeder::class);

        //? Factories
        Category::factory(8)->create();
        Article::factory(20)->create();
        Comment::factory(20)->create();
    }
}
