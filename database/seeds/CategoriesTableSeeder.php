<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use App\Category;


class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        //
        for ($i=0; $i < 4; $i++) {
            $new_category_object = new Category();
            $new_category_object->name = $faker->words(3, true);
            $slug = Str::slug($new_category_object->name, '-');
            //Salvo slug su variabile
            $slug_default = $slug;
            $post_found = Category::where('slug', $slug)->first();
            $counter = 1;
            //Ciclo finchè un nuovo post è stato trovato e associo a ogni slug il titolo del post dividendo ogni parola con un trattino.
            while($post_found) {
                $slug = $slug_default . '-' . $counter;
                $counter++;
                $post_found = Category::where('slug', $slug)->first();
            }
            $new_category_object->slug = $slug;
            $new_category_object->save();
        }
    }
}
