@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Edit Events</h1>
    </div>

    <div class="col-lg-8">
        <form method="post" action="/dashboard/events/{{ $event->id }}/edit" class="mb-5" enctype="multipart/form-data">
            @method('put')
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                    name="title" required autofocus value="{{ old('title', $event->title) }}">
                @error('title')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="published_at" class="form-label">Publihed Date</label>
                <input type="datetime" class="form-control @error('published_at') is-invalid @enderror" id="published_at"
                    name="published_at" required autofocus value="{{ old('published_at', $event->published_at) }}">
                @error('published_at')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                @error('content')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
                <input id="content" type="hidden" name="content" value="{{ old('content', $event->content) }}">
                <trix-editor input="content"></trix-editor>
            </div>
            <button type="submit" class="btn btn-primary">Edit Events</button>
        </form>
    </div>
@endsection
