<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //Decido quali elementi voglio salvare.
    //EDIT: aggiunto category_id
    protected $fillable = ['title', 'description', 'slug', 'category_id'];

    public function category() {
        return $this->belongsTo('App\Category');
    }
}
