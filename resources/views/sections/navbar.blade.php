<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="/" class="nav-link">Inicio</a>
    </li>
    {{-- <li class="nav-item d-none d-sm-inline-block">
      <a href="#" class="nav-link">Contact</a>
    </li> --}}
  </ul>

  <!-- SEARCH FORM -->
  {{-- <form class="form-inline ml-3">
    <div class="input-group input-group-sm">
      <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
      <div class="input-group-append">
        <button class="btn btn-navbar" type="submit">
          <i class="fa fa-search"></i>
        </button>
      </div>
    </div>
  </form> --}}

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!-- Notifications Dropdown Menu -->
    {{-- <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="fa fa-th-large"></i>        
      </a>
      <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
        <a class="dropdown-item"  href="{{ route('logout') }}">
          <i class="fas fa-sign-out-alt"></i> &nbsp; Salir
        </a>
      </div>
    </li> --}}
    <a type="button" class="btn btn-outline-danger btn-sm" href="{{ route('logout') }}">
      <i class="fas fa-power-off"></i> Cerrar Sesion
    </a>
  </ul>
</nav>
<!-- /.navbar -->