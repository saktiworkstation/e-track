<div class="container py-3" id="events">
    <header>
        <div class="pricing-header p-3 pb-md-4 mx-auto text-center">
            <h1 class="display-4 fw-normal text-body-emphasis">Events</h1>
            <p class="fs-5 text-body-secondary">Always check the latest news and events, don't miss any interesting
                things from us!.</p>
        </div>
    </header>

    <main>
        <div class="row row-cols-1 row-cols-md-3 mb-3 text-center">
            @foreach ($events as $event)
                <div class="col py-2">
                    <div class="card">
                        <div class="card-header">
                            {{ $event->title }}
                        </div>
                        <div class="card-body">
                            <blockquote class="blockquote mb-0">
                                <p>{{ $event->content }}</p>
                                <footer class="blockquote-footer">published at <cite
                                        title="Source Title">{{ $event->published_at }}</cite></footer>
                            </blockquote>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center">
            {{ $events->links() }}
        </div>
</div>
