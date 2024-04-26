<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" hrefaria-current="page"
                    href="/dashboard">
                    <span data-feather="home"></span>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('dashboard/tickets') ? 'active' : '' }}" href="/dashboard/tickets">
                    <span data-feather="shopping-bag"></span>
                    My Tickets
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('dashboard/notifications/user') ? 'active' : '' }}"
                    href="/dashboard/notifications/user">
                    <span data-feather="bell"></span>
                    My Notification
                </a>
            </li>
        </ul>

        @can('admin')
            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1">
                <span>Administrator</span>
            </h6>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('dashboard/tickets/manage*') ? 'active' : '' }}"
                        href="/dashboard/tickets/manage">
                        <span data-feather="file-plus"></span>
                        Tickets
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('dashboard/tickets/report*') ? 'active' : '' }}"
                        href="/dashboard/tickets/report">
                        <span data-feather="file-text"></span>
                        User Tickets Report
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('dashboard/events*') ? 'active' : '' }}" href="/dashboard/events">
                        <span data-feather="calendar"></span>
                        Events
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('dashboard/notifications') ? 'active' : '' }}"
                        href="/dashboard/notifications">
                        <span data-feather="archive"></span>
                        Notifications
                    </a>
                </li>
            </ul>
        @endcan
    </div>
</nav>
