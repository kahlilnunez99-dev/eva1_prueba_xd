# Fintech Solutions S.A. - Sprint 0

## Descripcion

Proyecto del Sprint 0 para la startup Fintech Solutions. Basicamente es un backend hecho con Laravel que corre en Docker, usa MySQL como base de datos y Nginx como servidor web. La idea es dejar todo funcionando para que despues se puedan agregar los modulos del negocio.

---

## Como instalar y levantar el proyecto

### 1. Instalar Docker Desktop
Descargar e instalar desde la pagina oficial:
https://www.docker.com/products/docker-desktop/

### 2. Instalar WSL (Windows Subsystem for Linux)
Docker necesita Linux para funcionar en Windows. Abrir una terminal y ejecutar:
```bash
wsl --install
```
Despues de que termine, reiniciar el PC para que se apliquen los cambios.

### 3. Clonar el repositorio y configurar el entorno
```bash
git clone <url-del-repositorio>
cd eva1_blas_elizabeth
```
Copiar el archivo de variables de entorno:
```bash
copy .env.example .env
```

### 4. Instalar dependencias y preparar la base de datos
Ejecutar estos comandos en orden:
```bash
docker compose up -d --build
docker compose exec app composer install
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate
docker compose exec app php artisan db:seed
```

### 5. Verificar que funcione
Abrir en el navegador o ejecutar en la terminal:
```bash
curl http://localhost:8080/api/health
```
Si todo esta bien, deberia responder:
```json
{"status":"online","version":"1.0.0","environment":"docker"}
```

### Iniciar el proyecto
```bash
docker compose up -d
```

### Detener el proyecto
```bash
docker compose down
```

---

## Arquitectura y Ciclo de Vida

### Patron MVC

Usamos el patron MVC que viene con Laravel, que basicamente separa el codigo en 3 partes:

```
  Cliente (navegador)  --->  Nginx  --->  PHP/Laravel  --->  MySQL
```

- **Modelo:** es el archivo que representa una tabla de la BD. Nosotros tenemos `Client.php` que representa la tabla `clients`. Usa Eloquent que es el ORM de Laravel para no tener que escribir SQL a mano.
- **Vista:** como estamos haciendo una API, no hay vistas HTML. Lo que devolvemos son respuestas en JSON.
- **Controlador:** es el que recibe la peticion y decide que hacer. Tenemos el `HealthController` que devuelve el estado del sistema.

### Como funciona una peticion

Cuando alguien entra por ejemplo a `GET /api/health` pasa esto:

1. Nginx recibe la peticion en el puerto 8080
2. Como es PHP, Nginx se la manda a PHP-FPM por el puerto 9000
3. Laravel busca en `routes/api.php` que controlador le toca
4. El controlador hace lo que tiene que hacer (en este caso devolver el status)
5. Si necesitara datos, el controlador usaria el modelo para consultar MySQL
6. Se arma el JSON de respuesta y se le devuelve al cliente

---

## Criterios de Calidad del Sprint 0

| Criterio | Que hicimos | Por que | Donde se ve |
|----------|------------|---------|-------------|
| Modularidad | Usamos MVC de Laravel | Asi cada cosa esta en su lugar, los modelos en una carpeta, los controladores en otra | `app/Models/`, `app/Http/Controllers/`, `routes/` |
| Mantenibilidad | Usamos migraciones y seeders | Para que cualquiera del equipo pueda tener la misma BD sin tener que crear tablas a mano | `database/migrations/`, `database/seeders/` |
| Claridad de configuracion | Pusimos todo en el `.env` | Las contraseñas y configuraciones no quedan en el codigo, se pueden cambiar facil | `.env`, `.env.example` |
| Separacion de responsabilidades | Cada archivo hace una sola cosa | El controlador no toca la BD directo y el modelo no sabe nada de HTTP | `HealthController.php`, `Client.php` |
| Trazabilidad de errores | Laravel guarda logs | Si algo falla se puede revisar en `storage/logs/` | `LOG_CHANNEL=stack` en `.env` |
| Portabilidad | Usamos Docker | Con un comando se levanta todo, no importa si usas Windows, Mac o Linux | `docker-compose.yml`, `Dockerfile` |

---

## Rol del Backend

El backend es lo que corre en el servidor y el usuario no ve. En nuestro proyecto hace lo siguiente:

- **Recibe peticiones:** escucha las solicitudes HTTP que manda el cliente (GET, POST, etc.)
- **Procesa la logica:** por ejemplo valida que un email no este repetido antes de guardar un cliente
- **Consulta la BD:** usa Eloquent para conectarse a MySQL de forma segura sin escribir SQL directo
- **Devuelve respuestas:** arma un JSON con los datos y un codigo HTTP (200 si salio bien, 400 si hay error)

Basicamente el backend es el intermediario entre el cliente y la base de datos, el cliente nunca accede directo a MySQL.

---

## Analisis de las piezas de software

Aca se explica para que sirve cada archivo importante del proyecto y por que se uso:

| Archivo | Para que sirve | Por que lo usamos |
|---------|---------------|-------------------|
| `docker-compose.yml` | Define los 3 contenedores (Nginx, PHP, MySQL) y como se conectan | Para que todo el entorno se levante con un solo comando y sea portable |
| `Dockerfile` | Arma la imagen de PHP con las extensiones necesarias (pdo_mysql, zip) y Composer | Para que el contenedor de PHP tenga todo lo que Laravel necesita |
| `docker/nginx/default.conf` | Configura Nginx para que mande las peticiones PHP al contenedor de la app | Para que Nginx funcione como proxy inverso y se comunique con PHP-FPM |
| `bootstrap/app.php` | Configura Laravel y registra los archivos de rutas (api.php, web.php) | Es el archivo principal que arranca la aplicacion |
| `routes/api.php` | Define las rutas de la API, en nuestro caso `GET /api/health` | Para que Laravel sepa que controlador ejecutar segun la URL |
| `app/Http/Controllers/HealthController.php` | Controlador que devuelve el estado del sistema en JSON | Para responder al endpoint de salud con el status, version y environment |
| `app/Http/Controllers/Controller.php` | Clase base de la que heredan todos los controladores | Si mas adelante hay logica compartida entre controladores, se pone aca |
| `app/Models/Client.php` | Modelo que representa la tabla `clients` en la BD | Para interactuar con la tabla usando Eloquent sin escribir SQL a mano |
| `database/migrations/create_clients_table.php` | Crea la tabla `clients` con sus campos en MySQL | Para versionar la estructura de la BD y que todos tengan la misma tabla |
| `database/seeders/ClientSeeder.php` | Inserta 3 clientes de prueba en la tabla | Para verificar que la conexion a la BD funciona y tener datos de ejemplo |
| `database/seeders/DatabaseSeeder.php` | Seeder principal que llama al ClientSeeder | Es el punto de entrada cuando se ejecuta `php artisan db:seed` |
| `config/database.php` | Tiene la configuracion de conexion a MySQL | Lee las variables del `.env` para conectarse a la BD |
| `config/app.php` | Configuracion general de Laravel (nombre, key, timezone) | Laravel lo necesita para arrancar correctamente |
| `config/logging.php` | Configura donde se guardan los logs de errores | Para que los errores queden registrados en `storage/logs/` |
| `.env` | Variables de entorno (credenciales de BD, debug, etc.) | Para separar la configuracion del codigo y no subir contraseñas a git |
| `.env.example` | Plantilla del `.env` sin datos sensibles | Para que al clonar el repo se sepa que variables configurar |

---

## Endpoint

| Metodo | URL | Respuesta |
|--------|-----|-----------|
| GET | `http://localhost:8080/api/health` | `{"status":"online","version":"1.0.0","environment":"docker"}` |

Devuelve **200 OK**.

---

## Pruebas de Migraciones y Seeders

### Migraciones

Corrimos `php artisan migrate` y se creo la tabla sin problemas:

```
2025_04_14_000001_create_clients_table ........................ 60.06ms DONE
```

La tabla `clients` quedo con los campos: `client_id`, `first_name`, `last_name`, `email` (unico), `phone_number`, `date_of_birth`, `created_at` y `updated_at`. Con esto confirmamos que la conexion a MySQL funciona bien.

### Seeders

Corrimos `php artisan db:seed` y se metieron 3 clientes de prueba:

| client_id | first_name | last_name | email | phone_number |
|-----------|-----------|-----------|-------|-------------|
| 1 | Juan | Perez | juan.perez@email.com | +56912345678 |
| 2 | Maria | Lopez | maria.lopez@email.com | +56987654321 |
| 3 | Carlos | Gonzalez | carlos.gonzalez@email.com | +56911223344 |

### Endpoint /api/health

Probamos con curl y devuelve:
```json
{"status":"online","version":"1.0.0","environment":"docker"}
```
Con **200 OK**, o sea que todo esta andando bien.

---

## Tecnologias

- PHP 8.2
- Laravel 12
- MySQL 8.0
- Nginx 1.24
- Docker
- Eloquent ORM
