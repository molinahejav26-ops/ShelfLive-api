<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Item;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Datos de ejemplo (los mismos que se ven en la web). Contraseña de todos: "password".
     * Se lanza con: php artisan migrate:fresh --seed
     */
    public function run(): void
    {
        foreach (['Videojuegos', 'Libros', 'Cómics'] as $name) {
            Category::create(['name' => $name]);
        }

        $productos = [
            ['0045496478704', 'The Legend of Zelda: Tears of the Kingdom', 'Nintendo Switch', 'Videojuegos'],
            ['9788497596824', 'Dune', null, 'Libros'],
            ['9788418040275', 'Watchmen', null, 'Cómics'],
        ];
        foreach ($productos as [$barcode, $title, $platform, $category]) {
            Product::create([
                'barcode' => $barcode,
                'title' => $title,
                'platform' => $platform,
                'category_id' => Category::where('name', $category)->value('id'),
            ]);
        }

        User::factory()->create(['name' => 'Lucía Martín', 'email' => 'lucia@shelflife.app', 'role' => 'admin']);
        $nuria = User::factory()->create(['name' => 'Nuria Gómez', 'email' => 'nuria.gomez@gmail.com']);
        $alex = User::factory()->create(['name' => 'Álex Romero', 'email' => 'alex.romero@icloud.com']);

        $items = [
            [$nuria, 'The Legend of Zelda: Tears of the Kingdom', 'new', 54.90],
            [$nuria, 'Dune', 'used', 12.50],
            [$alex, 'Watchmen', 'new', 24.95],
        ];
        foreach ($items as [$user, $title, $state, $price]) {
            Item::create([
                'user_id' => $user->id,
                'product_id' => Product::where('title', $title)->value('id'),
                'state' => $state,
                'purchase_price' => $price,
            ]);
        }
    }
}
