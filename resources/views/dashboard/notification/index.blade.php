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

    <div class="table-responsive col-sd-11">
        <div class="col-sm-2 mb-3 mb-sm-4">
            <div class="card border-primary">
                <div class="card-body">
                    <a href="/dashboard/notifications/create" class="btn btn-primary my-1">Create new Notifications</a>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4>Notifications</h4>
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">User</th>
                                <th scope="col">Message</th>
                                <th scope="col">Status</th>
                                <th scope="col">Link</th>
                                <th scope="col">Created at</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($notifications as $notif)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $notif->user_id }}</td>
                                    <td>{!! $notif->message !!}</td>
                                    <td>{{ $notif->status }}</td>
                                    <td>{{ $notif->link }}</td>
                                    <td>{{ $notif->created_at }}</td>
                                    <td>
                                        <a href="/dashboard/notifications/{{ $notif->id }}/edit"
                                            class="badge bg-warning">
                                            <span data-feather="edit"></span>
                                        </a>
                                        <form action="/dashboard/notifications/{{ $notif->id }}/delete" method="post"
                                            class="d-inline">
                                            @method('delete')
                                            @csrf
                                            <button class="badge bg-danger border-0"
                                                onclick="return confirm('Are you sure want to delete {{ $notif->title }}?')">
                                                <span data-feather="x-circle"></span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
