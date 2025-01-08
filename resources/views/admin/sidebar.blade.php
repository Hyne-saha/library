
            <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100 admin_sidebar">
                <a href="/" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none text-center margin-0-auto p-10">
                @php
                    $adminusers = session('adminusers'); 
                @endphp
                <span class="fs-5 d-none d-sm-inline">{{ $adminusers->name }}</span> 
                </a>
                <hr />
                <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                    <li class="nav-item">
                        <a href="{{ route('admin.addbooks') }}" class="nav-link align-middle px-0">
                            <i class="fs-4 bi-clipboard-plus"></i> <span class="ms-1 d-none d-sm-inline">Add Books</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.users') }}"  class="nav-link align-middle px-0">
                            <i class="fs-4 bi-people"></i> <span class="ms-1 d-none d-sm-inline">Users</span> </a>
                        
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.bookDetails') }}" class="nav-link px-0 align-middle">
                            <i class="fs-4 bi-table"></i> <span class="ms-1 d-none d-sm-inline">Book Details</span></a>
                    </li>
                </ul>
                <hr>

                </div>
        