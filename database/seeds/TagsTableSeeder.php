<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Tag;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        //
        for ($i=0; $i < 3; $i++) {

            $new_tag_object = new Tag();
            $new_tag_object->name = $faker->words(3, true);
            $slug = Str::slug($new_tag_object->name);
            $slug_default = $slug;
            $tag_found = Tag::where('slug', $slug)->first();
            $counter = 1;
            while($tag_found) {
                $slug = $slug_default . '-' . $counter;
                $counter++;
                $tag_found = Tag::where('slug', $slug)->first();
            }
            $new_tag_object->slug = $slug;
            $new_tag_object->save();
        }
    }
}
