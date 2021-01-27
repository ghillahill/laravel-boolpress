<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //Decido quali elementi voglio salvare.
    protected $fillable = ['title', 'description', 'slug'];

    public function category() {
        return $this->belongsTo('App\Category');
    }
}
