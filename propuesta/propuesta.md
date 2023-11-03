% Finca Monterruiz
% Ana Rodríguez Pérez
% Curso 2023/24

# Descripción general del proyecto

Finca Monterruiz es un sitio web diseñado para ofrecer diversas experiencias en torno al viñedo. Esto incluye visitas guiadas, catas, talleres y más. Todo ello con el objetivo de compartir con los visitantes las diferentes actividades que se llevan a cabo en el viñedo a lo largo del año.

## Funcionalidad principal de la aplicación

La funcionalidad principal de la aplicación es permitir a los usuarios explorar el catálogo de actividades disponibles y seleccionar las que deseen realizar. Para comenzar, solo necesitan registrarse antes de hacer una reserva, proporcionando información como la fecha, hora y el número de personas que participarán en la actividad. Luego, podrán completar el proceso realizando el pago correspondiente.

Después de participar en una actividad, los usuarios tienen la posibilidad de compartir sus opiniones a través de comentarios y valoraciones. Estos se exhibirán en la sección de comentarios en la página principal, lo que permitirá a otros usuarios ver y tomar en cuenta esas opiniones.

El administrador podrá controlar los elementos de la aplicación, incluyendo las actividades, los usuarios y reservas, a través del panel de administración.

## Objetivos generales

* Objetivo: Explorar, reservar y evaluar las diferentes actividades y experiencias que se ofrecen relacionadas con el enoturismo.

* Casos de uso: 
    * Invitado (usuario no logueado):
        - Registrarse.
        - Buscar y filtrar actividades.
        - Enviar Mensaje de Contacto.
        - Explorar Historia de la Empresa.
        - Explorar Comentarios y Valoraciones.
    * Usuario logueado:
        - Iniciar sesión.
        - Buscar y filtrar actividades.
        - Reservar actividad.
        - Valorar actividad.
        - Modificar perfil.
    * Administrador:
        - Validar/bloquear usuario.
        - Añadir actividad.
        - Modificar actividad.
        - Borrar actividad.
        - Bloquear actividad.

# Elemento de innovación

- Uso del framework Laravel.
- Implementación del sistema de newsletter. (opcional)
- Uso de la API de autenticación de Google para habilitar el inicio de sesión con cuentas de Gmail. (opcional)
- Uso de API de mapas.
