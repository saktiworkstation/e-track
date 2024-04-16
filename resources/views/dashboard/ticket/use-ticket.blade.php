@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Enter the ticket code to use the ticket</h1>
    </div>

    <div class="col-lg-8">
        <form method="post" action="/dashboard/tickets/submit" class="mb-5" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="code" class="form-label">Ticket code to be used</label>
                <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" code="code"
                    required autofocus value="{{ old('code') }}">
                @error('code')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Submit ticket code</button>
        </form>
    </div>
@endsection
