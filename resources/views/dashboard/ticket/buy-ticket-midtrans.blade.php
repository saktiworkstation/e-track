@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Ticket purchase</h1>
    </div>

    <div class="col-lg-8">
        <form id="payment-form" class="mb-5">
            @csrf
            <div class="mb-3">
                <label for="amount" class="form-label">Amount</label>
                <input type="number" class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount"
                    required autofocus value="{{ old('amount') }}">
                @error('amount')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <input type="hidden" id="ticket_id" name="ticket_id" value="{{ $ticketId }}">
            <button id="pay-button" class="btn btn-primary">Buy Ticket</button>
        </form>
    </div>
@endsection
