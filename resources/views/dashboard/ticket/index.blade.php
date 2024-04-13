@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">{{ $title }}</h1>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show col-lg-8" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="table-responsive col-lg-5">
        @if (Request::is('dashboard/tickets/manage'))
            <div class="col-sm-8 mb-3 mb-sm-4">
                <div class="card border-primary">
                    <div class="card-body">
                        <a href="/dashboard/tickets/create" class="btn btn-primary my-1 mx-1">Create new Ticket</a>
                        <a href="/dashboard/tickets/create" class="btn btn-primary my-1 mx-1">Manage Ticket</a>
                    </div>
                </div>
            </div>
        @endif
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Username</th>
                    <th scope="col">Ticket Name</th>
                    <th scope="col">Status</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Total Price</th>
                    @if (Request::is('dashboard/tickets/manage'))
                        <th scope="col">Action</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($tickets as $ticket)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $ticket->users->username }}</td>
                        <td>{{ $ticket->tickets->name }}</td>
                        <td>{{ $ticket->status }}</td>
                        <td>{{ $ticket->amount }}</td>
                        <td>{{ $ticket->total_price }}</td>
                        @if (Request::is('dashboard/tickets/manage'))
                            <td>
                                @if ($ticket->status == 0 && Request::is('dashboard/tickets/manage'))
                                    <a href="/dashboard/tickets/{{ $ticket->slug }}" class="badge bg-info">
                                        <span data-feather="check-circle"></span>
                                    </a>
                                @endif
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
