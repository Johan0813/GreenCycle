# 

GreenCycle es una aplicación web orientada a la gestión y seguimiento de árboles.
El proyecto permite registrar árboles y consultar su información, incluyendo nivel, salud, progreso y estado.
Actualmente se está desarrollando la primera parte de la funcionalidad relacionada con la gestión de árboles.

# Alcance actual

En este primer sprint, se encuentra disponible lo siguiente:

Consultar la lista de árboles registrados.
Consultar la información de un árbol mediante su ID.
Plantar/registrar un nuevo árbol.
Los nuevos árboles se crean con:
- Nivel: 0
- Salud: 100
- Progreso: 0
- Estado: ACTIVE

# Stack / requisitos

Para ejecutar el proyecto se necesita:

- PHP
- Laravel
- Composer
- Node.js
- npm
- Base de datos PostgreSQL
- Git

# Instalación:

# Clonar el repositorio
git clone https://github.com/Johan0813/GreenCycle.git

# Entrar a la carpeta
cd GreenCycle

# Instalar las dependencias de PHP
composer install

# Instalar las dependencias de Node
npm install

# Crear el archivo .env a partir de .env.example
# Generar la clave de la aplicación:
php artisan key:generate

# Configurar en .env los datos de conexión a la base de datos
# Ejecutar las migraciones
php artisan migrate

# Configuración
APP_NAME=GreenCycle
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://greencycle.test

DB_CONNECTION=pgsql
DB_HOST=
DB_PORT=5432
DB_DATABASE=... 
DB_USERNAME= ...
DB_PASSWORD= ...

# Ejecución

El proyecto se ejecuta utilizando Laravel Herd, una vez instalado y configurado el proyecto, se puede acceder a la aplicación desde:
http://greencycle.test

# Pruebas/verificación

Para comprobar que la aplicación funciona correctamente, se pueden verificar las funcionalidades de gestión de árboles:
- Visualización de todos los árboles.
- Consulta de un árbol mediante su ID.
- Creación de un nuevo árbol mediante la opción "Plantar árbol".

También se puede comprobar el estado de las migraciones con:

php artisan migrate:status

# API

Las rutas relacionadas con los árboles se encuentran en
 `routes/web.php`.


| GET | `/api/trees`,  Muestra todos los árboles registrados. 
| GET | `/api/tree/{id}`,  Muestra la información de un árbol mediante su ID. 
| POST | `/api/add/tree`,  Crea un nuevo árbol. 
Al crear un árbol, sus valores iniciales son:
- Nivel: 0
- Salud: 100
- Progreso: 0
- Estado: ACTIVE

# Credenciales demo

Actualmente no aplica, ya que la funcionalidad de autenticación todavía está pendiente de implementación.

# Equipo y atribuciones

# Integrantes

- Alanis
- Johan
- Charlie

# Ramas de trabajo

- Main
- Develop
- Alanis
- Johan
- Charlie