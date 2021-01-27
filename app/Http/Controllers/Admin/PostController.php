<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'posts' => Post::all()
        ];
        return view('admin.posts.home', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $form_data = $request->all();
        $new_post_object = new Post();
        $new_post_object->fill($form_data);
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
        return redirect()->route('admin.posts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
        if(!$post) {
            abort(404);
        }
        return view('admin.posts.show', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
        if(!$post) {
            abort(404);
        }
        return view('admin.posts.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
        $form_data = $request->all();

        if($form_data['title'] != $post->title) {
            $slug = Str::slug($form_data['title']);
            //Salvo slug su variabile
            $slug_default = $slug;
            // verifico che lo slug non esista nel database
            $post_found = Post::where('slug', $slug)->first();
            $counter = 1;
            //Ciclo finchè un nuovo post è stato trovato e associo a ogni slug il titolo del post dividendo ogni parola con un trattino.
            while($post_found) {
                $slug = $slug_default . '-' . $counter;
                $counter++;
                $post_found = Post::where('slug', $slug)->first();
            }
            //Assegno slug a Post
            $form_data['slug'] = $slug;
        }
        $post->update($form_data);
        //Eseguo redirect su pagina Admin Home
        return redirect()->route('admin.posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
        $post->delete();
        return redirect()->route('admin.posts.index');
    }
}
