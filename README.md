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


# Instrucciones de Despliegue para Finca Monterruiz

Bienvenido al proyecto Finca Monterruiz. Sigue estas instrucciones para configurar y desplegar el proyecto en tu entorno local.

## Configuración del Entorno
### Requisitos Previos

Asegúrate de tener instalados PHP, Composer y PostgreSQL en tu sistema. Aquí tienes los comandos para instalarlos en un sistema basado en Debian como Ubuntu:

```bash
# Instalar PHP y extensiones necesarias
sudo apt install php8.2 php8.2-amqp php8.2-cgi php8.2-cli php8.2-common php8.2-curl php8.2-fpm php8.2-gd php8.2-igbinary php8.2-intl php8.2-mbstring php8.2-opcache php8.2-pgsql php8.2-readline php8.2-redis php8.2-sqlite3 php8.2-xml php8.2-zip

# Instalar Composer
sudo apt install composer

# Instalar PostgreSQL
sudo apt install postgresql postgresql-client postgresql-contrib
```

Antes de ejecutar las migraciones, asegúrate de tener configurada la base de datos PostgreSQL creando un nuevo usuario y una base de datos.

Ejecuta el siguiente comando para crear un nuevo usuario (serás solicitado a ingresar una contraseña para el nuevo usuario): `sudo -u postgres createuser -P fincamonterruiz`
Crea una nueva base de datos asignada a este usuario ejecutando: `sudo -u postgres createdb -O fincamonterruiz fincamonterruiz`

## Configuración del Proyecto

1. Clona el repositorio y navega al directorio del proyecto. Instala las dependencias de PHP con Composer. `composer install`
2. Copia el archivo .env.example a .env y genera la clave de la aplicación:  .env.example a .env
`cp .env.example .env`
`php artisan key:generate`
5. Configurar el archivo `.env` con los detalles de tu entorno. (EXPLICADO A CONTINUACIÓN)
6. Ejecutar migraciones de la base de datos `php artisan migrate`
7. Ejecutar seeders de la base de datos `php artisan db:seed`

## Configurar el archivo `.env` con los detalles de tu entorno.
```plaintext
APP_NAME=FincaMonterruiz
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=fincamonterruiz
DB_USERNAME=fincamonterruiz
DB_PASSWORD=

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=s3
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=smtp.googlemail.com
MAIL_PORT=465
MAIL_USERNAME=tucorreo@gmail.com
MAIL_PASSWORD=contraseñade16dígitos
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=tucorreo@gmail.com
MAIL_FROM_NAME="${APP_NAME}"

PAYPAL_CLIENT_ID=
PAYPAL_SECRET=

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION= eu-north-1
AWS_BUCKET=fincamonterruiz
AWS_USE_PATH_STYLE_ENDPOINT=false

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=mt1

VITE_APP_NAME="${APP_NAME}"
VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_HOST="${PUSHER_HOST}"
VITE_PUSHER_PORT="${PUSHER_PORT}"
VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"

```

** Para obtener la configuración necesaria para integrar PayPal en tu proyecto, como las credenciales API (Client ID y Secret), debes seguir estos pasos:

1. Crear una Cuenta PayPal
2. Acceder al Panel de Desarrollador de PayPal. Aquí es donde puedes gestionar tus aplicaciones y obtener tus credenciales API.
   Para obtener tus credenciales API, necesitas crear una aplicación en el Dashboard de Desarrolladores:
   
    Haz clic en "Crear Aplicación". Esto te llevará a una página donde puedes nombrar tu nueva aplicación. El nombre que elijas te ayudará a identificar la aplicación en tu Dashboard, pero no afecta a la funcionalidad de la API.
    Selecciona la cuenta de sandbox asociada que deseas usar para pruebas. PayPal proporciona cuentas de sandbox que simulan el entorno de pago en vivo para pruebas de desarrollo.

3. Obtener Credenciales API

Una vez que hayas creado tu aplicación, serás redirigido a la página de detalles de la aplicación, donde podrás encontrar tus credenciales:

    Client ID: Es un identificador público que se utiliza para autenticar tu aplicación con los servidores de PayPal.
    Secret: Es una clave secreta que se utiliza en combinación con el Client ID para obtener tokens de acceso. Debes mantener esta clave segura y no exponerla públicamente.

** Para configurar el servicio de correo en Laravel utilizando un servidor SMTP como Gmail, necesitas establecer varias variables de entorno en tu archivo .env.

Obtener Credenciales de Gmail

MAIL_MAILER=smtp
MAIL_HOST=smtp.googlemail.com
MAIL_PORT=465
MAIL_USERNAME=tucorreo@gmail.com
MAIL_PASSWORD=contraseñade16dígitos
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=tucorreo@gmail.com
MAIL_FROM_NAME="${APP_NAME}"


Para generar una contraseña de aplicación:

-Ve a tu cuenta de Google y selecciona "Seguridad".
-En "Iniciar sesión en Google", selecciona "Contraseñas de aplicación". Puede que necesites iniciar sesión nuevamente en este punto.
-En "Seleccionar aplicación", elige "Otra (nombre personalizado)" y ponle un nombre que te permita recordar para qué es esta contraseña, como "Laravel".
-Haz clic en "Generar" y Google te proporcionará una contraseña de 16 caracteres. Esta es la contraseña que usarás para MAIL_PASSWORD en tu archivo .env.

** Configuración a Amazon S3: 

Paso 1: Crear un Bucket de S3

Ingresa a la consola de administración de AWS.
Busca el servicio S3 y crea un nuevo bucket.
Configura las opciones del bucket según tus necesidades, asegurándote de establecer los permisos adecuados.

Paso 2: Obtener Credenciales de AWS

Navega al servicio IAM en la consola de AWS.
Crea un nuevo usuario con acceso programático y asigna la política AmazonS3FullAccess a este usuario o una política personalizada que se ajuste mejor a tus necesidades de seguridad.
Anota el Access Key ID y el Secret Access Key proporcionados tras la creación del usuario.

Paso 3: Configurar .env

Añade o actualiza las siguientes claves en tu archivo .env con los valores obtenidos:

AWS_ACCESS_KEY_ID=your_access_key_id
AWS_SECRET_ACCESS_KEY=your_secret_access_key
AWS_DEFAULT_REGION=your_bucket_region
AWS_BUCKET=your_bucket_name

AWS_ACCESS_KEY_ID: Tu ID de clave de acceso de AWS.
AWS_SECRET_ACCESS_KEY: Tu clave de acceso secreta de AWS.
AWS_DEFAULT_REGION: La región en la que se encuentra tu bucket de S3 (por ejemplo, us-east-1).
AWS_BUCKET: El nombre de tu bucket de S3.

Paso 4: Configurar el Sistema de Archivos

Asegúrate de que el sistema de archivos de tu aplicación Laravel esté configurado para usar S3 como disco predeterminado o según sea necesario. Esto se hace en el archivo config/filesystems.php bajo la clave disks, asegurándote de que el disco s3 esté configurado correctamente y utilizando las variables de entorno que definiste:

's3' => [
    'driver' => 's3',
    'key' => env('AWS_ACCESS_KEY_ID'),
    'secret' => env('AWS_SECRET_ACCESS_KEY'),
    'region' => env('AWS_DEFAULT_REGION'),
    'bucket' => env('AWS_BUCKET'),
],

## Ejecución de la Aplicación

1. Ejecutar `php artisan serve` para iniciar el servidor de desarrollo.
2. Acceder a la aplicación en `http://localhost:8000`.
