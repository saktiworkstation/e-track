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

    <div class="table-responsive col-md-11">
        @if (Request::is('dashboard/tickets/manage'))
            <div class="col-sm-4 mb-3 mb-sm-4">
                <div class="card border-primary">
                    <div class="card-body">
                        <a href="/dashboard/tickets/create" class="btn btn-primary my-1 mx-3">Create new Ticket</a>
                        <a href="/dashboard/tickets/create" class="btn btn-primary my-1">Manage Ticket</a>
                    </div>
                </div>
            </div>
        @endif
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h4>User tickets table</h4>
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Username</th>
                                <th scope="col">Ticket Name</th>
                                <th scope="col">Status</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Code</th>
                                <th scope="col">Total Price</th>
                                @if (Request::is('dashboard/tickets/manage'))
                                    <th scope="col">Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($userTickets as $ticket)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $ticket->users->username }}</td>
                                    <td>{{ $ticket->tickets->name }}</td>
                                    <td>{{ $ticket->status }}</td>
                                    <td>{{ $ticket->amount }}</td>
                                    <td>{{ $ticket->code }}</td>
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
                @if (Request::is('dashboard/tickets/manage'))
                    <div class="col-md-6">
                        <h4>Tickets table</h4>
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Descriptions</th>
                                    <th scope="col">Stok</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tickets as $ticket)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $ticket->name }}</td>
                                        <td>{!! $ticket->descriptions !!}</td>
                                        <td>{{ $ticket->stok }}</td>
                                        <td>{{ $ticket->status }}</td>
                                        <td>{{ $ticket->price }}</td>
                                        <td>
                                            <a href="/dashboard/tickets/{{ $ticket->id }}/edit" class="badge bg-warning">
                                                <span data-feather="edit"></span>
                                            </a>
                                            <form action="/dashboard/tickets/{{ $ticket->id }}/delete" method="post"
                                                class="d-inline">
                                                @method('delete')
                                                @csrf
                                                <button class="badge bg-danger border-0"
                                                    onclick="return confirm('Are you sure want to delete {{ $ticket->name }}?')">
                                                    <span data-feather="x-circle"></span>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
