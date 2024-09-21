# Contact Management System

Este es un sistema de gestión de contactos desarrollado utilizando **Laravel 11** y **Angular 17**. Permite realizar operaciones CRUD (Crear, Leer, Actualizar, Eliminar) para gestionar contactos y sus detalles.

## Tecnologías Utilizadas

- **Backend**: Laravel 11
- **Frontend**: Angular 17 (no standalone)
- **Base de datos**: MySQL 8.0.30

## Endpoints

A continuación se presentan los endpoints de la API:

| Método  | Endpoint                          | Descripción                         |
|---------|-----------------------------------|-------------------------------------|
| GET     | `/`                               | Página principal                    |
| GET     | `api/contacts`                   | Obtiene la lista de contactos       |
| POST    | `api/contacts`                   | Crea un nuevo contacto              |
| GET     | `api/contacts/{contact}`         | Obtiene un contacto específico      |
| PUT     | `api/contacts/{contact}`         | Actualiza un contacto existente     |
| DELETE  | `api/contacts/{contact}`         | Elimina un contacto                 |
| GET     | `api/user`                       | Obtiene información del usuario     |
| GET     | `sanctum/csrf-cookie`            | Obtiene el cookie CSRF para la autenticación |
| GET     | `storage/{path}`                 | Accede a archivos en el almacenamiento local |
| GET     | `up`                              | Muestra el estado de la aplicación  |

## Instalación

Sigue estos pasos para instalar y ejecutar el proyecto:

1. **Clona el repositorio**:
   ```bash
   git clone https://github.com/FranciscoFloat/Libreta-de-Contactos.git
2. Instala las dependencias de PHP:
  composer install
3. Copia el archivo de configuración de ejemplo:
  cp .env.example .env
4. Genera la clave de la aplicación:
  php artisan key:generate
5. Configura tu base de datos en el archivo .env. (agregar: FRONTEND_URL=http://localhost:4200)
6. Ejecuta las migraciones y el seeder:
  php artisan migrate --seed
7. Instala las dependencias de Angular:
  cd frontend
  npm install
8. Ejecuta la aplicación Angular:
  ng serve
9. Ejecuta el servidor de Laravel:
   
Consideraciones
Asegúrate de tener configurada tu base de datos correctamente en el archivo .env.
Si utilizas Laravel Sanctum para la autenticación, asegúrate de seguir la documentación oficial para configurarlo adecuadamente.
Para acceder a la aplicación, visita http://localhost:4200 para Angular y http://localhost:8000 para Laravel.
  



