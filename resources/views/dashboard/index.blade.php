@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Welcome back, {{ auth()->user()->name }}</h1>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show col-lg-8" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="table-responsive col-sd-11">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4>User Data</h4>
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Username</th>
                                <th scope="col">Email</th>
                                <th scope="col">Role</th>
                                <th scope="col" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                {{-- ? Skip the logged in user data --}}
                                @if ($user->id == auth()->user()->id)
                                    @continue
                                @endif
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if ($user->status == 0)
                                            Member
                                        @elseif ($user->status == 1)
                                            Admin
                                        @else
                                            This role is not available, please press the action button on this user
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="/auth/{{ $user->id }}/roling" class="badge bg-warning"
                                            onclick="return confirm('Are you sure want to change | {{ $user->email }} | Role?')">
                                            <span data-feather="edit"></span>
                                        </a>
                                        <form action="/auth/{{ $user->id }}/delete" method="post" class="d-inline">
                                            @method('delete')
                                            @csrf
                                            <button class="badge bg-danger border-0"
                                                onclick="return confirm('Are you sure want to delete | {{ $user->email }} | ?')">
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
