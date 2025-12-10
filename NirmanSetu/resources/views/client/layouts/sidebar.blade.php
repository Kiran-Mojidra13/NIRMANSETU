<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand -->
    <a href="{{ route('client.dashboard') }}" class="brand-link text-center">
        <span class="brand-text font-weight-bold">NirmanSetu</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">

                <li class="nav-item">
                    <a href="{{ route('client.dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('client.projects') }}" class="nav-link">
                        <i class="nav-icon fas fa-tasks"></i>
                        <p>Projects</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('client.bills') }}" class="nav-link">
                        <i class="nav-icon fas fa-file-invoice-dollar"></i>
                        <p>Bills</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('client.documents') }}" class="nav-link">
                        <i class="nav-icon fas fa-file-upload"></i>
                        <p>Documents</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('client.daily_updates') }}" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Daily Updates</p>
                    </a>
                </li>

               <!-- Profile & Logout just below Team -->
<li class="nav-item mt-2">
    <a href="{{ route('client.profile.edit') }}" class="nav-link">
        <i class="nav-icon fas fa-user-circle"></i>
        <p>Profile</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('logout') }}" class="nav-link"
       onclick="event.preventDefault();document.getElementById('logout-form').submit();">
        <i class="nav-icon fas fa-sign-out-alt"></i>
        <p>Logout</p>
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>
</li>


            </ul>
        </nav>
    </div>
</aside>
