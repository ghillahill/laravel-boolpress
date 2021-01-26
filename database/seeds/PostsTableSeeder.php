<?php

use Illuminate\Database\Seeder;
use App\Post;
use Faker\Generator as Faker;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        // $this->call(PostsTableSeeder::class);
        for ($i=0; $i < 15; $i++) {
            $new_post_object = new Post();
            $new_post_object->title = $faker->sentence(3);
            $new_post_object->description = $faker->sentence(10);
            $slug = Str::slug($new_post_object->title);
            $new_post_object->date_of_post = $faker->date();
            //Salvo slug su variabile
            $slug_default = $slug;
            $post_found = Post::where('slug', $slug)->first();
            $counter = 1;
            //Ciclo finchè un nuovo post è stato trovato e associo a ogni slug il titolo del post dividendo ogni parola con un trattino.
            while($post_found) {
                $slug = $slug_default . '-' . $counter;
                $counter++;
                $post_found = Post::where('slug', $slug)->first();
            }
            $new_post_object->slug = $slug;
            $new_post_object->save();
        }
    }
}
