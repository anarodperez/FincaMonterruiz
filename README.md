<p align="center"><img src="/public/img/logo.png" width="300" alt="Finca Monterruiz Logo"></p>

<h1 align="center"> Finca Monterruiz </h1>

<p align="center">
  &copy; Curso 2023/24 «Finca Monterruiz» | Ana Rodríguez Pérez
</p>

## 1. Descripción General del Proyecto

Finca Monterruiz es un sitio web diseñado para ofrecer diversas experiencias en torno al viñedo, incluyendo visitas guiadas, catas, talleres y más. Nuestro objetivo es compartir con los visitantes las diferentes actividades que se llevan a cabo en el viñedo a lo largo del año.

## 2. Funcionalidad Principal de la Aplicación

La funcionalidad principal de la aplicación es permitir a los usuarios explorar y reservar actividades. Los usuarios pueden registrarse, elegir fechas y horarios, y realizar pagos para confirmar sus reservas. Además, pueden compartir sus experiencias mediante comentarios y valoraciones, que serán visibles en la página principal para otros usuarios. El administrador tiene control completo sobre las actividades, reservas y usuarios a través del panel de administración.

## 3. Objetivos Generales

- **Objetivo:** Explorar, reservar y evaluar las diferentes actividades y experiencias relacionadas con el enoturismo.
- **Casos de Uso:**
  - **Invitado (usuario no logueado):**
    - Registrarse.
    - Buscar y filtrar actividades.
    - Enviar mensaje de contacto.
    - Explorar historia de la empresa.
    - Explorar comentarios y valoraciones.
  - **Usuario Logueado:**
    - Iniciar sesión.
    - Reservar actividad.
    - Valorar actividad.
    - Modificar perfil.
  - **Administrador:**
    - Gestionar usuarios y actividades.

## 4. Elementos de Innovación

- Uso del framework Laravel para el desarrollo de la aplicación.
- Implementación de un sistema de newsletter.
- Integración con API de mapas para visualización geográfica.


# Instrucciones de Despliegue de Mi Proyecto

## Configuración del Entorno

1. Instalar PHP, Composer y PostgreSQL.
2. Clonar el repositorio de mi proyecto.

## Configuración del Proyecto

1. Navegar al directorio del proyecto.
2. Ejecutar `./setup.sh` (Unix/Linux) o `setup.bat` (Windows) para configurar el proyecto.
3. Configurar el archivo `.env` con los detalles de tu entorno.

## Ejecución de la Aplicación

1. Ejecutar `php artisan serve` para iniciar el servidor de desarrollo.
2. Acceder a la aplicación en `http://localhost:8000`.

