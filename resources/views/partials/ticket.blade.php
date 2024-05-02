<div class="container py-3" id="tickets">
    <header>
        <div class="pricing-header p-3 pb-md-4 mx-auto text-center">
            <h1 class="display-4 fw-normal text-body-emphasis">Tickets</h1>
            <p class="fs-5 text-body-secondary">Find the right ticket according to your needs, also enjoy various promos
                and different ticket types.</p>
        </div>
    </header>

    <main>
        <div class="row row-cols-1 row-cols-md-3 mb-3 text-center">
            @foreach ($tickets as $ticket)
                <div class="col">
                    <div class="card mb-4 rounded-3 shadow-sm border-primary">
                        <div class="card-header py-3 text-bg-primary border-primary">
                            <h4 class="my-0 fw-normal">{{ $ticket->name }}</h4>
                        </div>
                        <div class="card-body">
                            <h1 class="card-title pricing-card-title">${{ $ticket->price }}</h1>
                            <p class="mt-3 mb-4">
                                {!! $ticket->descriptions !!}
                            </p>
                            <a href="/dashboard/tickets/purchase/{{ $ticket->id }}"
                                class="w-100 btn btn-lg btn-primary">Detail</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center">
            {{ $tickets->links() }}
        </div>
</div>
