<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Category;
use App\Post;
use App\Tag;

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
        //passo dati tabella categories su funzione create.
        $data = [
            'categories' => Category::all(),
            'tags' => Tag::all()
        ];
        return view('admin.posts.create', $data);
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
        //Sync dei tag a un post
        $new_post_object->tags()->sync($form_data['tags']);
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
        //passo dati tabella categories per poterci accedere nella fase edit
        $data = [
            'post' => $post,
            'categories' => Category::all(),
            'tags' => Tag::all()
        ];

        return view('admin.posts.edit', $data);
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
        $post->tags()->sync($form_data['tags']);
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
        //Svuoto array per asssicurarmi di non eliminare anche gli eventuali tags
        $post->tags()->sync([]);
        $post->delete();
        return redirect()->route('admin.posts.index');
    }
}
