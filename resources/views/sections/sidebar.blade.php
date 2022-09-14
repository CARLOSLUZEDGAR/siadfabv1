 <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="" class="brand-link">
        <img src="/img/fabprueba.png" class="brand-image">
        <span class="brand-text font-weight-light">SIADFAB</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-1 pb-1 mb-1 d-flex">
            <div class="info">
              <router-link class="nav-link" to='/datosUser'>
                <a id="nombre" class="d-block"></a>
              </router-link>
               
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              @can('payament', Model::class)
                  <li>prueba</li>
              @endcan
              @can('personal-destinos', Model::class)
                <li class="nav-header" style="padding-left: 1px;">DESTINOS</li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="nav-icon fab fa-avianex"></i>
                      <p>
                        DESTINOS
                        <i class="fa fa-angle-left right"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">

                      @can('view-destper', Model::class)
                      <li class="nav-item">
                        <router-link class="nav-link" to='/listarPersonalDestinos'>
                        &nbsp;&nbsp;<i class="fas fa-luggage-cart"></i>&nbsp;&nbsp;&nbsp;
                          <p>Personal Destinos</p>
                        </router-link>
                      </li>
                      @endcan

                      @can('view-destn1', Model::class)
                      <li class="nav-item">
                        <router-link class="nav-link" to='/nivel1destino'>
                        &nbsp;&nbsp;<i class="fas fa-globe-americas"></i>&nbsp;&nbsp;&nbsp;
                          <p>Destinos nivel 1</p>
                        </router-link>
                      </li>
                      @endcan

                      @can('view-destn2', Model::class)
                      <li class="nav-item">
                        <router-link class="nav-link" to='/nivel2destino'>
                        &nbsp;&nbsp;<i class="fas fa-globe-europe"></i>&nbsp;&nbsp;&nbsp;
                          <p>Destinos nivel 2</p>
                        </router-link>
                      </li>
                      @endcan

                      @can('view-destn3', Model::class)
                      <li class="nav-item">
                        <router-link class="nav-link" to='/nivel3destino'>
                        &nbsp;&nbsp;<i class="fas fa-globe-asia"></i>&nbsp;&nbsp;&nbsp;
                          <p>Destinos nivel 3</p>
                        </router-link>
                      </li>
                      @endcan

                      @can('view-destn4', Model::class)
                      <li class="nav-item">
                        <router-link class="nav-link" to='/nivel4destino'>
                        &nbsp;&nbsp;<i class="fas fa-globe-africa"></i>&nbsp;&nbsp;&nbsp;
                          <p>Destinos nivel 4</p>
                        </router-link>
                      </li>
                      @endcan

                    </ul>
                  </li> 
              @endcan

              @can('configuracion', Model::class)
                <li class="nav-header" style="padding-left: 1px;">CONFIGURACIÓN</li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fab fa-avianex"></i>
                    <p>
                      TABLAS
                      <i class="fa fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    @can('view-tablas', Model::class)
                    <li class="nav-item">
                      <router-link class="nav-link" to='/listarTablas'>
                      &nbsp;&nbsp;<i class="fas fa-luggage-cart"></i>&nbsp;&nbsp;&nbsp;
                        <p>Tablas</p>
                      </router-link>
                    </li>
                    @endcan
                  </ul>
                </li> 
              @endcan
               
              {{-- PERMISO SIDEBAR 1 --}}
              @can('destinos_cargos', Model::class)
              <li class="nav-header" style="padding-left: 1px;">AYUDAS</li>
                {{-- PERMISO SIDEBAR 2 --}}
                @can('destinos', Model::class)
                <li class="nav-item">{{-- DESTINOS --}}
                  <a href="#" class="nav-link">
                    <i class="nav-icon fab fa-avianex"></i>
                    <p>
                      LISTAS
                      <i class="fa fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">

                    @can('view-destper', Model::class)
                    <li class="nav-item">
                      <router-link class="nav-link" to='/listas'>
                      &nbsp;&nbsp;<i class="fas fa-luggage-cart"></i>&nbsp;&nbsp;&nbsp;
                        <p>Listas</p>
                      </router-link>
                    </li>
                    @endcan

                  </ul>
                </li>  
                @endcan               
              @endcan

              

              {{-- PERMISO SIDEBAR 1 --}}
                @can('administracion', Model::class)
                <li class="nav-header" style="padding-left: 1px;">ADMINISTRACIÓN</li>
                <li class="nav-item">{{-- ACCESO DEL SISTEMA --}}
                    <a href="#" class="nav-link">
                      <i class="nav-icon fas fa-users"></i>
                      <p>
                        ACCESO DEL SISTEMA
                        <i class="fas fa-angle-left right"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: none;">
                      @can('view-user', Model::class)
                       <li class="nav-item">
                        <router-link class="nav-link" to='/usuarios'>
                          <i class="nav-icon fas fa-users-cog"></i>
                          <p>Usuarios</p>
                        </router-link>
                      </li>
                      @endcan
                      @can('view-rol', Model::class)
                      <li class="nav-item">
                        <router-link class="nav-link" to='/roles'>
                          <i class="nav-icon fas fa-user-clock"></i>
                          <p>Roles</p>
                        </router-link>
                      </li>
                      @endcan
                      @can('view-permi', Model::class)
                      <li class="nav-item">
                        <router-link class="nav-link" to='/permisos'>
                          <i class="nav-icon fas fa-user-edit"></i>
                          <p>Permisos</p>
                        </router-link>
                      </li>
                      @endcan

                    </ul>
                </li>
                @endcan

                {{-- AYUDAS --}}
                {{-- <li class="nav-item">
                    <router-link class="nav-link" to='/ayuda'>
                      <i class="nav-icon fas fa-info-circle"></i>
                      <p>AYUDAS</p>
                    </router-link>
                </li> --}}

                <li class="nav-item">{{-- ACERCA DE --}}
                    <router-link class="nav-link" to='/acercade'>
                      <i class="nav-icon fas fa-boxes"></i>
                      <p>ACERCA DE</p>
                    </router-link>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->

    </div>
    <!-- /.sidebar -->

</aside>
