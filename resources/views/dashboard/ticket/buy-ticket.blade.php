@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Ticket purchase</h1>
    </div>

    <div class="col-lg-8">
        <form method="post" action="/dashboard/tickets/purchase" class="mb-5" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="amount" class="form-label">amount</label>
                <input type="number" class="form-control @error('amount') is-invalid @enderror" id="amount"
                    name="amount" required autofocus value="{{ old('amount') }}">
                @error('amount')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="user" class="form-label">User</label>
                <select class="form-select" name="user_id" id="user">
                    @foreach ($tickets as $ticket)
                        @if (old('id', $ticketId) == $ticket->id)
                            <option value="{{ $ticket->id }}" selected>{{ $ticket->name }} | Price/1 Ticket :
                                {{ $ticket->price }}
                            </option>
                        @else
                            <option value="{{ $ticket->id }}">{{ $ticket->name }} | Price/1 Ticket : {{ $ticket->price }}
                            </option>
                        @endif
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Buy Ticket</button>
        </form>
    </div>
@endsection
