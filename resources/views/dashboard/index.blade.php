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

    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show col-lg-8" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="table-responsive col-sd-11">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <form method="post" action="/auth/{{ $acount->id }}/edit" class="mb-5"
                        enctype="multipart/form-data">
                        @method('put')
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" required autofocus value="{{ old('name', $acount->name) }}">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Edit Events</button>
                    </form>
                </div>
            </div>
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
                                        @if ($user->is_admin == 0)
                                            Member
                                        @elseif ($user->is_admin == 1)
                                            Admin
                                        @else
                                            This role is not available, please press the action button on this user
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <form action="/auth/{{ $user->id }}/roling" method="POST" class="d-inline">
                                            @method('put')
                                            @csrf
                                            <button type="submit" class="badge bg-warning border-0"
                                                onclick="return confirm('Are you sure want to change | {{ $user->email }} | Role?')">
                                                <span data-feather="edit"></span>
                                            </button>
                                        </form>
                                        <form action="/auth/{{ $user->id }}/delete" method="post" class="d-inline">
                                            @method('delete')
                                            @csrf
                                            <button class="badge bg-danger border-0"
                                                onclick="return confirm('Are you sure want to delete | {{ $user->email }} | ?')">
                                                <span data-feather="trash"></span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
