<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid col-md-7">
    <a class="navbar-brand" href="{{ route('todo') }}">ToDo List</a>
    <div class="navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
             aria-expanded="false">
            {{ Auth::user()->name }}
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
            <li><a class="dropdown-item" href="{{ route('user.update') }}">Update Data</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
