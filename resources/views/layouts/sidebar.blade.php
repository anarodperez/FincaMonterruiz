<!-- Aside a la izquierda -->

<!-- Botón para colapsar el menú en pantallas pequeñas -->
<button class="btn btn-primary d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" style="background: #536b59">
    <i class="fas fa-bars"></i>
</button>

<nav class="col-12 col-md-4 col-lg-2 d-md-block bg-light sidebar collapse" id="sidebarMenu">
    <div class="sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item my-2 mx-3">
                <a class="nav-link active" href="{{ route('admin.index') }}">
                    <i class="bi bi-house-door-fill"></i> Inicio
                </a>
            </li>
            <li class="nav-item my-2 mx-3">
                <a class="nav-link" href="{{ route('admin.actividades.index') }}">
                    <i class="bi bi-calendar3"></i> Actividades
                </a>
            </li>
            <li class="nav-item my-2 mx-3">
                <a class="nav-link" href="{{ route('admin.usuarios.index') }}">
                    <i class="bi bi-people"></i> Usuarios
                    @if (isset($notifications) && $notifications->nuevos_usuarios_count > 0)
                        <span class="badge badge-warning">{{ $notifications->nuevos_usuarios_count }}</span>
                    @endif

                </a>
            </li>
            <li class="nav-item my-2 mx-3">
                <a class="nav-link" href="{{ route('admin.reservas.index') }}">
                    <i class="bi bi-bookmark"></i> Reservas
                    @if (isset($notifications) && $notifications->nuevos_reservas_count > 0)
                        <span class="badge badge-warning">{{ $notifications->nuevos_reservas_count }}</span>
                    @endif
                </a>
            </li>
            <li class="nav-item my-2 mx-3">
                <a class="nav-link" href="{{ route('admin.facturas.index') }}">
                    <i class="bi bi-file-earmark-text"></i>  Facturas
                </a>
            </li>
            <li class="nav-item my-2 mx-3">
                <a class="nav-link" href="{{ route('admin.valoraciones.index') }}">
                    <i class="bi bi-star"></i> Valoraciones
                    @if (isset($notifications) && $notifications->nuevos_valoraciones_count > 0)
                        <span class="badge badge-warning">{{ $notifications->nuevos_valoraciones_count }}</span>
                    @endif
                </a>
            </li>
            <li class="nav-item my-2 mx-3">
                <a class="nav-link" href="{{ route('admin.newsletters.index') }}">
                    <i class="bi bi-envelope-fill"></i> Newsletter
                </a>
            </li>
            <li class="nav-item my-2 mx-3">
                <a class="nav-link" href="{{ route('admin.horarios.index') }}">
                    <i class="bi bi-clock"></i> Horarios
                </a>
            </li>
        </ul>
    </div>
</nav>
