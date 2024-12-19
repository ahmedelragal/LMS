<nav class="navbar navbar-expand navbar-light navbar-bg">
    <a class="sidebar-toggle js-sidebar-toggle">
        <i class="hamburger align-self-center"></i>
    </a>

    <div class="navbar-collapse collapse">
        <ul class="navbar-nav navbar-align">
            {{-- <li class="nav-item dropdown">
                <a class="nav-icon dropdown-toggle" href="#" id="alertsDropdown" data-bs-toggle="dropdown">
                    <div class="position-relative">
                        <i class="align-middle" data-feather="bell"></i>
                        <span class="indicator">4</span>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0" aria-labelledby="alertsDropdown">
                    <div class="dropdown-menu-header">
                        4 New Notifications
                    </div>
                    <div class="list-group">
                        <!-- Your notification content here -->
                    </div>
                    <div class="dropdown-menu-footer">
                        <a href="#" class="text-muted">Show all notifications</a>
                    </div>
                </div>
            </li> --}}
            {{-- <li class="nav-item dropdown">
                <a class="nav-icon dropdown-toggle" href="#" id="messagesDropdown" data-bs-toggle="dropdown">
                    <div class="position-relative">
                        <i class="align-middle" data-feather="message-square"></i>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0" aria-labelledby="messagesDropdown">
                    <div class="dropdown-menu-header">
                        4 New Messages
                    </div>
                    <div class="list-group">
                        <!-- Your message content here -->
                    </div>
                    <div class="dropdown-menu-footer">
                        <a href="#" class="text-muted">Show all messages</a>
                    </div>
                </div>
            </li> --}}

            <!-- Display Admin Info and Logout Button -->
            <li class="nav-item dropdown">
                <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                    <i class="align-middle" data-feather="settings"></i>
                </a>

                <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                    <!-- Display Admin's Profile Image and Name -->
                    {{-- <img src="{{ asset('storage/' . Auth::guard('admin')->user()->image ?? 'default-avatar.jpg') }}" class="avatar img-fluid rounded me-1" alt="{{ Auth::guard('admin')->user()->name }}" /> --}}
                    <span class="text-dark">{{ Auth::guard('admin')->user()->name }}</span>
                </a>

                <div class="dropdown-menu dropdown-menu-end">
                    {{-- <a class="dropdown-item" href="#"><i class="align-middle me-1" data-feather="user"></i> Profile</a> --}}
                    {{-- <div class="dropdown-divider"></div> --}}
                    
                    <!-- Logout Button -->
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item">
                            <i class="align-middle me-1" data-feather="log-out"></i> Log out
                        </button>
                    </form>
                </div>
            </li>
        </ul>
    </div>
</nav>
