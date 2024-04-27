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

    <div class="row">
        @foreach ($notifications as $notif)
            <div class="col-sm-6 mb-3 mb-sm-0 pb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Sent on. {{ $notif->created_at }}</h5>
                        <p class="card-text">{!! $notif->message !!}.</p>
                        <div class="d-flex">
                            <div class="p-2 w-100"><a href="#" class="btn btn-primary"><span
                                        data-feather="external-link"></span>
                                    Go
                                    To the link of message</a></div>
                            <div class="p-2 flex-shrink-1"><a href="#" class="btn btn-danger"><span
                                        data-feather="trash-2"></span> Delete</a></div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
