# GreenCycle

GreenCycle es una aplicación web orientada a la gestión y seguimiento de árboles.

El proyecto permite registrar árboles y consultar su información, incluyendo nivel, salud, progreso y estado.

Actualmente se está desarrollando la primera parte de la funcionalidad relacionada con la gestión de árboles.

# Alcance actual

En este primer sprint, se encuentra disponible lo siguiente:

- Consultar la lista de árboles registrados.
- Consultar la información de un árbol mediante su ID.
- Plantar/registrar un nuevo árbol.

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
- Laravel Herd

# Instalación local

## 1. Clonar el repositorio

Abra PowerShell y ejecute:

```bash
git clone https://github.com/Johan0813/GreenCycle.git
```

Después, entre a la carpeta del proyecto:

```bash
cd GreenCycle
```

## 2. Instalar las dependencias de PHP

Ejecute:

```bash
composer install
```

## 3. Instalar las dependencias de Node

Ejecute:

```bash
npm install
```

## 4. Crear el archivo `.env`

Crear el archivo `.env` a partir del archivo `.env.example`.

## 5. Generar la clave de la aplicación

Ejecute:

```bash
php artisan key:generate
```

## 6. Configurar la conexión a la base de datos

Configure en el archivo `.env` los datos de conexión a PostgreSQL.

Ejemplo:

```env
APP_NAME=GreenCycle
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://greencycle.test

DB_CONNECTION=pgsql
DB_HOST=
DB_PORT=5432
DB_DATABASE=...
DB_USERNAME=...
DB_PASSWORD=...
```

No se deben incluir contraseñas reales ni otros datos privados en el README.

## 7. Ejecutar las migraciones

Ejecute:

```bash
php artisan migrate
```

# Configuración

El proyecto utiliza PostgreSQL como base de datos.

La conexión con la base de datos se configura mediante las variables del archivo `.env`.

El proyecto utiliza Laravel Herd para el entorno de desarrollo local.

# Ejecución

El proyecto se ejecuta utilizando Laravel Herd.

Una vez instalado y configurado el proyecto, se puede acceder a la aplicación desde:

```text
http://greencycle.test
```

# Pruebas / verificación

Para comprobar que la aplicación funciona correctamente, se pueden verificar las siguientes funcionalidades:

- Visualización de todos los árboles.
- Consulta de un árbol mediante su ID.
- Creación de un nuevo árbol mediante la opción "Plantar árbol".

También se puede comprobar el estado de las migraciones ejecutando:

```bash
php artisan migrate:status
```

# API

Las rutas relacionadas con la gestión de árboles se encuentran en:

```text
routes/web.php
```

## 1. Obtener todos los árboles

**Método:**

```text
GET
```

**Ruta:**

```text
/api/trees
```

Muestra todos los árboles registrados en el sistema.

## 2. Obtener un árbol por ID

**Método:**

```text
GET
```

**Ruta:**

```text
/api/tree/{id}
```

Muestra la información de un árbol específico mediante su ID.

## 3. Crear un nuevo árbol

**Método:**

```text
POST
```

**Ruta:**

```text
/api/add/tree
```

Crea un nuevo árbol en el sistema.

Al crear un árbol, sus valores iniciales son:

- Nivel: 0
- Salud: 100
- Progreso: 0
- Estado: ACTIVE

# Credenciales demo

Actualmente no aplica, ya que la funcionalidad de autenticación todavía está pendiente de implementación.

# Equipo y atribuciones

## Integrantes

- Alanis
- Johan
- Charlie

## Ramas de trabajo

- Main
- Develop
- Alanis
- Johan
- Charlie
