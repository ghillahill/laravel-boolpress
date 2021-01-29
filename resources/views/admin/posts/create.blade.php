@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Creazione nuovo post</h1>
                <a href="{{ route('admin.posts.index') }}" class="btn btn-primary">
                    Tutti i posts
                </a>
            </div>
            <form action="{{ route('admin.posts.store') }}" method="post">
                @csrf
                <div class="form-group">
                    <label>Titolo</label>
                    <input type="text" name="title" class="form-control" placeholder="Inserire Titolo..." maxlength="255" required>
                </div>
                <div class="form-group">
                    <label>Descrizione</label>
                    <textarea name="description" class="form-control" rows="10" placeholder="Inserire Descrizione..." required></textarea>
                </div>
                <div class="form-group">
                    <label>Categoria</label>
                    <select class="form-control" name="category_id">
                        <option value="">-Seleziona Categoria-</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <p>Seleziona Tags: </p>
                    @foreach ($tags as $tag)
                        <div class="form-check">
                            <input name="tags[]" class="form-check-input" type="checkbox" value="{{ $tag->id }}">
                            <label class="form-check-label">
                                {{ $tag->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">
                        Crea post
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
