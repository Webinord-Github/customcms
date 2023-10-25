<div class="adminNav">
    <div class="sectionDiv">
        <ul>
            <li class="navLink">
            <a href="/admin"><i class="fa fa-home mr-4  mt-0.5"></i>Dasboard</a>
            </li>
            <li class="navLink">
                <a href="{{ route('pages.index') }}"><i class="fa fa-file-text mr-4 mt-0.5" aria-hidden="true"></i>Pages</a>
            </li>
            @can('SuperAdmin', App\Models\User::class)
            <li class="navLink">
                <a href="{{ route('users.index') }}"><i class="fa fa-user mr-4 mt-0.5" aria-hidden="true"></i>Users</a>
            </li>
            @endcan
            <li class="navLink">
                <a href="/admin/posts"><i class="fa fa-newspaper mr-4 mt-0.5" aria-hidden="true"></i>Posts</a>
            </li>
            <li class="navLink">
                <a href="/admin/events"><i class="fa-solid fa-bell mr-4 mt-0.5" aria-hidden="true"></i>Events</a>
            </li>
            <li class="navLink">
                <a href="{{ route('medias.index') }}"><i class="fa fa-download mr-4 mt-0.5" aria-hidden="true"></i>Media</a>
            </li>
            <li class="navLink">
                <a href="{{ route('medias.index') }}"><i class='fas fa-key mr-4 mt-0.5' aria-hidden="true"></i>Roles</a>
            </li>
        </ul>
    </div>
    <div class="logoutDiv">
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <a href="route('logout')"
            onclick="event.preventDefault();
                this.closest('form').submit();">
           Logout
        </a>
    </form>
    </div>
    <div class="admin__logo">
    <img src="{{ asset('files/logo-webinord-clair.png') }}" alt="">
    </div>
</div>
