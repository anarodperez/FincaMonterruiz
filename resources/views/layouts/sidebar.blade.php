            <!-- Aside a la izquierda -->

            <nav class="col-md-2 d-md-block bg-light sidebar">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('admin.index') }}">
                                <i class="fas fa-home"></i> Inicio
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.actividades.index') }}">
                                <i class="fas fa-wine-glass"></i> Actividades
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-list-alt"></i> Categorías
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.usuarios.index') }}">
                                <i class="fas fa-users"></i> Usuarios
                                @if (isset($notifications) && $notifications->nuevos_usuarios_count > 0)
                                    <span class="badge badge-warning">{{ $notifications->nuevos_usuarios_count }}</span>
                                @endif

                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.reservas.index') }}">
                                <i class="fas fa-calendar-check"></i> Reservas
                                @if (isset($notifications) && $notifications->nuevos_reservas_count > 0)
                                    <span class="badge badge-warning">{{ $notifications->nuevos_reservas_count }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.valoraciones.index') }}">
                                <i class="fas fa-star"></i> Valoraciones y Comentarios
                                @if (isset($notifications) && $notifications->nuevos_valoraciones_count > 0)
                                <span class="badge badge-warning">{{ $notifications->nuevos_valoraciones_count }}</span>
                            @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.horarios.index') }}">
                                <i class="fas fa-clock"></i> Horarios de Actividades
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
