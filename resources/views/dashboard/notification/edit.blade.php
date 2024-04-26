@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Edit Notifications</h1>
    </div>

    <div class="col-lg-8">
        <form method="post" action="/dashboard/notifications/{{ $notification->id }}" class="mb-5"
            enctype="multipart/form-data">
            @method('put')
            @csrf
            <div class="mb-3">
                <label for="user" class="form-label">User</label>
                <select class="form-select" name="user_id" id="user">
                    @foreach ($users as $user)
                        @if (old('user_id', $notification->user_id) == $user->id)
                            <option value="{{ $user->id }}" selected>{{ $user->name }}</option>
                        @else
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="link" class="form-label">Link (opsional)</label>
                <input type="text" class="form-control @error('link') is-invalid @enderror" id="link" name="link"
                    autofocus value="{{ old('link', $notification->link) }}">
                @error('link')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">message</label>
                @error('message')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
                <input id="message" type="hidden" name="message" value="{{ old('message', $notification->message) }}">
                <trix-editor input="message"></trix-editor>
            </div>
            <button type="submit" class="btn btn-primary">Edit Notifications</button>
        </form>
    </div>
@endsection
