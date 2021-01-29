@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Modifica post {{ $post->id }}</h1>
                <a href="{{ route('admin.posts.index') }}" class="btn btn-primary">
                    Tutti i Post
                </a>
            </div>
            <form action="{{ route('admin.posts.update', ['post' => $post->id]) }}" method="post">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Titolo</label>
                    <input type="text" name="title" class="form-control" placeholder="Inserire Titolo..." value="{{ $post->title }}" maxlength="255" required>
                </div>
                <div class="form-group">
                    <label>Descrizione</label>
                    <textarea name="description" class="form-control" rows="10" placeholder="Inserire Descrizione..." required>{{ $post->description }}</textarea>
                </div>
                <div class="form-group">
                    <label>Categoria</label>
                    <select class="form-control" name="category_id">
                        <option value="">-Seleziona Categoria-</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ $category->id == $post->category_id ? 'selected=selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <p>Seleziona Tags: </p>
                    @foreach ($tags as $tag)
                        <div class="form-check">
                            <input name="tags[]" class="form-check-input" type="checkbox" value="{{ $tag->id }}" {{ $post->tags->contains($tag) ? 'checked=checked' : '' }}>
                            <label class="form-check-label">
                                {{ $tag->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">
                        Salva Post
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
