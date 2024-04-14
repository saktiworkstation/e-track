@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Edit Ticket</h1>
    </div>

    <div class="col-lg-8">
        <form method="post" action="/dashboard/tickets/{{ $ticket->id }}/edit" class="mb-5" enctype="multipart/form-data">
            @method('put')
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                    required autofocus value="{{ old('name', $ticket->name) }}">
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="stocks" class="form-label">Stocks</label>
                <input type="number" class="form-control  @error('stocks') is-invalid @enderror" id="stocks"
                    name="stocks" required value="{{ old('stocks', $ticket->stocks) }}">
                @error('stocks')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <input type="number" class="form-control  @error('status') is-invalid @enderror" id="status"
                    name="status" required value="{{ old('status', $ticket->status) }}">
                @error('status')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" class="form-control  @error('price') is-invalid @enderror" id="price"
                    name="price" required value="{{ old('price', $ticket->price) }}">
                @error('price')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="descriptions" class="form-label">Descriptions</label>
                @error('descriptions')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
                <input id="descriptions" type="hidden" name="descriptions"
                    value="{{ old('descriptions', $ticket->descriptions) }}">
                <trix-editor input="descriptions"></trix-editor>
            </div>
            <button type="submit" class="btn btn-primary">update Ticket</button>
        </form>
    </div>
@endsection
