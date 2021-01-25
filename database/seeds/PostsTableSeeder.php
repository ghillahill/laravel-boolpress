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
        for ($i=0; $i < 50; $i++) {
            $new_post_object = new Post();
            $new_post_object->title = $faker->sentence(3);
            $new_post_object->description = $faker->sentence(10);
            $new_post_object->date_of_post = $faker->date();
            $new_post_object->save();
        }

    }
}
