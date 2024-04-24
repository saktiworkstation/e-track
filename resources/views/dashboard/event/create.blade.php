@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Create new Events</h1>
    </div>

    <div class="col-lg-8">
        <form method="post" action="/dashboard/events" class="mb-5" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                    name="title" required autofocus value="{{ old('title') }}">
                @error('title')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="publihed_at" class="form-label">Publihed Date</label>
                <input type="datetime" class="form-control @error('publihed_at') is-invalid @enderror" id="publihed_at"
                    name="publihed_at" required autofocus value="{{ old('publihed_at') }}">
                @error('publihed_at')
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
                <input id="content" type="hidden" name="content" value="{{ old('content') }}">
                <trix-editor input="content"></trix-editor>
            </div>
            <button type="submit" class="btn btn-primary">Create Events</button>
        </form>
    </div>
@endsection
