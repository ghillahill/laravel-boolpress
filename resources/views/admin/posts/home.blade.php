@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Tutti i Posts</h1>
                <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
                    Crea Nuovo Post
                </a>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Titolo</th>
                        <th>Descrizione</th>
                        <th>Slug</th>
                        <th>Data</th>
                        <th>Azioni</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($posts as $post)
                        <tr>
                            <td>{{ $post->id }}</td>
                            <td>{{ $post->title }}</td>
                            <td>{{ $post->description }}</td>
                            <td>{{ $post->slug }}</td>
                            <td>{{ $post->date_of_post }}</td>
                            <td>
                                <a class="btn btn-info btn-sm" href="{{ route('admin.posts.show', ['post' => $post->id ]) }}">
                                    Visualizza
                                </a>
                                <a class="btn btn-warning btn-sm" href="{{ route('admin.posts.edit', ['post' => $post->id]) }}">
                                    Modifica
                                </a>
                                <form class="d-inline-block" action="{{ route('admin.posts.destroy', ['post' => $post->id]) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        Elimina
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
