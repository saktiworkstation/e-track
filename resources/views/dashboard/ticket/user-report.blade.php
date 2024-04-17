@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Tickets Report</h1>
    </div>

    <div class="table-responsive col-sd-11">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h4>User tickets report</h4>
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
                                <th scope="col">Last change</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($userTickets as $ticket)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $ticket->users->username }}</td>
                                    <td>{{ $ticket->tickets->name }}</td>
                                    <td>
                                        @if ($ticket->status == 0)
                                            Have not been used
                                        @elseif ($ticket->status == 1)
                                            Waiting for usage confirmation
                                        @else
                                            Already used
                                        @endif
                                    </td>
                                    <td>{{ $ticket->amount }}</td>
                                    <td>{{ $ticket->code }}</td>
                                    <td>{{ $ticket->total_price }}</td>
                                    <td>{{ $ticket->updated_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
