<div class="collapse navbar-collapse" id="navbarSupportedContent">
    <!-- Left Side Of Navbar -->
    <ul class="navbar-nav mr-auto">
    <!-- == -->
    @can('users.index')
    <li class="nav-item">
    <a class="nav-link" href="{{route('users.index')}}">Usuarios</a>
    </li>
    @endcan
    <!-- == -->
    @can('roles.index')
    <li class="nav-item">
    <a class="nav-link" href="{{route('roles.index')}}">Roles</a>
    </li>
    @endcan
    <!-- == -->
    @can('sucursales.index')
    <li class="nav-item">
    <a class="nav-link" href="{{route('sucursales.index')}}">Sucursales</a>
    </li>
    @endcan
    <!-- == -->
    @can('sucursal_usuario.index')
    <li class="nav-item">
    <a class="nav-link" href="{{route('sucursal_usuario.index')}}">Asignación Sucursales</a>
    </li>
    @endcan
    <!-- == -->
    @can('dropdown.almacen')
    <li class="nav-item dropdown">
    <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Almacen</a>
    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow" style="background-color: #F6F5A9">
        <!-- == -->
        @can('categoria.index')
        <li><a href="{{route('categoria.index')}}" class="dropdown-item"><i class="fas fa-list-alt"></i> Categorías</a></li>
        @endcan
        <!-- == -->
        @can('producto.index')
        <li><a href="{{route('articulo.index')}}" class="dropdown-item"><i class="fas fa-store"></i> Producto/Artículo</a></li>
        @endcan
        <!-- == -->
    </ul>
    </li>
    @endcan
    <!-- == -->
    @can('dropdown.compraegreso')
    <li class="nav-item dropdown">
    <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Compras y Egresos</a>
    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow" style="background-color: #F6F5A9">
        <!-- == -->
        @can('solicitudcompra.index')
        <li><a href="{{route('solicitudcompra.index')}}" class="dropdown-item"><i class="fas fa-cart-plus"></i> Solicitud y Compras</a></li>
        @endcan
        <!-- == -->
        @can('factura.index')
        <li><a href="{{route('factura.index')}}" class="dropdown-item"><i class="fas fa-file-invoice-dollar"></i> Facturas y Detalles</a></li>
        @endcan
        <!-- == -->
        @can('egreso.index')
        <li><a href="{{route('egreso.index')}}" class="dropdown-item"><i class="fas fa-file-invoice-dollar"></i> Egresos</a></li>
        @endcan
        <!-- == -->
        @can('preventivo.index')
        <li><a href="{{route('preventivo.index')}}" class="dropdown-item"><i class="fas fa-clipboard-list"></i> Preventivos</a></li>
        @endcan
        <!-- == -->
        @can('proveedor.index')
        <li><a href="{{route('proveedor.index')}}" class="dropdown-item"><i class="fas fa-warehouse"></i> Proveedores</a></li>
        @endcan
        <!-- == -->
    </ul>
    </li>
    @endcan
    <!-- == -->
    @can('dropdown.categoriaprogramatica')
    <li class="nav-item dropdown">
    <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Categorias Programaticas</a>
    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow" style="background-color: #F6F5A9">
        <!-- == -->
        @can('proyecto.index')
        <li><a href="{{route('proyecto.index')}}" class="dropdown-item"><i class="fas fa-clipboard-list"></i> Proyectos</a></li>
        @endcan
        <!-- == -->
        @can('partida.index')
        <li><a href="{{route('partida.index')}}" class="dropdown-item"><i class="fas fa-clipboard-list"></i> Partidas</a></li>
        @endcan
        <!-- == -->
    </ul>
    </li>
    @endcan
    <!-- == -->
    @can('dropdown.reportes')
    <li class="nav-item dropdown">
    <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Reportes</a>
    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow" style="background-color: #F6F5A9">
        <!-- == -->
        @can('reporte.ingresoarticulo_porfecha')
        <li><a href="{{route('v_ingresoarticulo_stock')}}" class="dropdown-item"><i class="fas fa-chart-pie"></i> Ingreso de Artículo: Por Fecha</a></li>
        @endcan
        <!-- == -->
        @can('reporte.proveedores_porfecha')
        <li><a href="{{route('v_articulo_proveedor')}}" class="dropdown-item"><i class="fas fa-chart-pie"></i> Proveedores: Por Fecha</a></li>
        @endcan
        <!-- == -->
        @can('reporte.egresoproducto_porfecha')
        <li><a href="{{route('v_egresoarticulo_stock')}}" class="dropdown-item"><i class="fas fa-chart-pie"></i> Egreso de Artículo: Por Fecha</a></li>
        @endcan
        <!-- == -->
        @can('reporte.egresoproducto_poroficina')
        <li><a href="{{route('v_egresoarticulo_oficina')}}" class="dropdown-item"><i class="fas fa-chart-pie"></i> Egreso de Artículo: Por Oficina</a></li>
        @endcan
        <!-- == -->
        @can('reporte.saldoproducto')
        <li><a href="{{route('v_saldoporarticulo')}}" class="dropdown-item"><i class="fas fa-chart-pie"></i> Saldo de Artículo</a></li>
        @endcan
        <!-- == -->
        @can('reporte.saldocategoria')
        <li><a href="{{route('v_saldocategoria')}}" class="dropdown-item"><i class="fas fa-chart-pie"></i> Saldo por Categoría</a></li>
        @endcan
        <!-- == -->
        @can('reporte.articulostock')
        <li><a href="{{route('v_articulostock')}}" class="dropdown-item"><i class="fas fa-chart-pie"></i> Artículo (Stock)</a></li>
        @endcan
        <!-- == -->
        <!-- == -->
        <li><a href="{{route('report_inventory_index')}}" class="dropdown-item"><i class="fas fa-chart-pie"></i> Inventario</a></li>
        <!-- == -->
        @can('reporte.articuloegresado')
        <li><a href="{{route('v_articuloegreso')}}" class="dropdown-item"><i class="fas fa-chart-pie"></i> Artículo (Egresado)</a></li>
        @endcan
        <!-- == -->
        <li><a href="{{route('solicitudesresumen_v')}}" class="dropdown-item"><i class="fas fa-chart-pie"></i> Resumen Solicitudes de Compra (Montos)</a></li>
        <!-- == -->
        <li><a href="{{route('egresosresumen_v')}}" class="dropdown-item"><i class="fas fa-chart-pie"></i> Resumen Egresos de Pedidos (Montos)</a></li>
         <!-- == -->
        <li><a href="{{route('kardex_articulo_v')}}" class="dropdown-item"><i class="fas fa-chart-pie"></i> Kardex de Solicitudes de Compras</a></li>
        <!-- == -->
        <!-- == -->
        <li><a href="{{route('r_proveedores')}}" target="_blank" class="dropdown-item"><i class="fas fa-chart-pie"></i> Todos los proveedores</a></li>
        <!-- == -->
        <!-- == -->
        <li><a href="{{route('view_dependencies_by_secretaries')}}" class="dropdown-item"><i class="fas fa-chart-pie"></i>Dependencias Por secretarias</a></li>
        <!-- == -->
    </ul>
    </li>
    @endcan
    <!-- == -->
    @can('dropdown.saldoinventario')
    <li class="nav-item dropdown">
    <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Saldo de Inventario</a>
    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow" style="background-color: #F6F5A9">
        <!-- == -->
        <li><a href="{{route('saldocompra.index')}}" class="dropdown-item"><i class="fas fa-cash-register"></i> Saldo de Inventarios</a></li>
        <!-- == -->
    </ul>
    </li>
    @endcan
    <!-- == -->
    </ul>

    <!-- Right Side Of Navbar -->
    <ul class="navbar-nav ml-auto">
    <!-- Authentication Links -->
    @guest
    <li class="nav-item">
        <a class="nav-link" href="{{ route('login') }}">{{ __('Iniciar Sesión') }}</a>
    </li>
    @if (Route::has('register'))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('register') }}">{{ __('Registro') }}</a>
        </li>
    @endif
    @else
    <li class="nav-item dropdown">
        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            {{\Carbon\Carbon::parse(now())->format('h:i A')}} -
            Hola! {{ Auth::user()->name }}  <span class="caret"></span>
        </a>

        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="{{ route('perfilusuario.index') }}"><i class="fas fa-user-circle"></i> Perfil Usuario</a>

            <a class="dropdown-item" href="{{ route('logout') }}"
               onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i> {{ __('Cerra Sesión') }}
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </li>
    @endguest
    </ul>
</div>