Este proyecto está basado en Laravel 8.

## Configuración del Proyecto

Siga estos pasos para configurar y ejecutar el proyecto localmente.

### Prerrequisitos

Asegúrese de tener instalados los siguientes requisitos:

- [Git](https://git-scm.com/)
- [Composer](https://getcomposer.org/)
- [PHP](https://www.php.net/) >= 7.x
- [MySQL](https://www.mysql.com/) o cualquier otro sistema de gestión de bases de datos compatible con Laravel

### Pasos de Configuración

- Clona el repositorio:git clone https://github.com/diego-agudelo-hf/api-axa.git

- Instalar dependencias:composer install

- Genera la clave de aplicación de Laravel: php artisan key:generate

- Copia el archivo de entorno: cp .env.example .env

- Ejecuta las migraciones para configurar la base de datos: php artisan migrate