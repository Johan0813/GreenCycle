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

---

# Sprint 2 — Lógica de negocio y cuidado de árboles

## 1. Descripción del Sprint 2

En el segundo sprint de GreenCycle se desarrolló la lógica de negocio del backend, enfocada en el cuidado, crecimiento y evolución de los árboles.

Se implementaron las validaciones necesarias para controlar el cuidado de árboles, la recuperación de salud, el progreso de niveles, los estados y los tiempos de espera entre cuidados.

También se incorporó la autenticación mediante Laravel Sanctum, la autorización por propiedad de los árboles y las pruebas automatizadas para comprobar el funcionamiento del sistema.

Las funcionalidades documentadas anteriormente corresponden al Sprint 1. Esta sección presenta los avances realizados durante el Sprint 2.

## 2. Funcionalidades implementadas

### 2.1. Autenticación de usuarios

Se implementó un sistema de autenticación utilizando **Laravel Sanctum**.

Actualmente permite:

- Registrar nuevos usuarios.
- Iniciar sesión mediante correo electrónico y contraseña.
- Generar tokens de autenticación.
- Consultar la información del usuario autenticado.
- Cerrar sesión e invalidar el token utilizado.
- Proteger endpoints mediante el middleware `auth:sanctum`.

Las contraseñas se almacenan utilizando el sistema de hash proporcionado por Laravel.

### 2.2. Cuidado de árboles

Se implementó un endpoint que permite aplicar cuidados a los árboles registrados.

Para realizar un cuidado, deben cumplirse las siguientes condiciones:

- El usuario debe estar autenticado.
- El árbol debe pertenecer al usuario que realiza la solicitud.
- El árbol debe encontrarse en estado `ACTIVE`.
- El árbol no puede encontrarse dentro de su período de cooldown.

Cuando se realiza un cuidado válido, el sistema aplica las siguientes reglas:

1. Incrementa el progreso del árbol en 1.
2. Recupera 20 puntos de salud, sin superar el máximo de 100.
3. Cuando se completan 5 cuidados, aumenta el nivel en 1.
4. Al aumentar de nivel, el progreso vuelve a 0.
5. Cuando el árbol alcanza el nivel 10, su estado cambia a `MATURE`.
6. Registra la fecha del último cuidado.
7. Establece un cooldown de 60 minutos antes del siguiente cuidado.

Todas estas validaciones se realizan desde el servidor.

### 2.3. Salud y deterioro de árboles

Se incorporó un servicio encargado de administrar el deterioro de salud de los árboles:

```text
app/Services/TreeHealthService.php
```

Este servicio se utiliza en el proceso de cuidado para aplicar las reglas relacionadas con el deterioro de salud.

La lógica de cuidado también permite recuperar salud, respetando el límite máximo de 100 puntos.

### 2.4. Estados de los árboles

Se incorporó un servicio para administrar los estados de los árboles:

```text
app/Services/TreeStateService.php
```

Los estados considerados en el sistema son:

| Estado | Descripción |
|--------|-------------|
| `ACTIVE` | El árbol está activo y puede recibir cuidados. |
| `MATURE` | El árbol alcanzó el nivel máximo de crecimiento. |
| `DEAD` | El árbol murió y no puede recibir más cuidados. |
| `HARVESTED` | El árbol ya fue cosechado y no puede recibir más cuidados. |

El endpoint de cuidado solo permite realizar acciones cuando el estado del árbol es `ACTIVE`.

La transición de `MATURE` a `HARVESTED` y el endpoint de cosecha quedan pendientes de implementación.

### 2.5. Seguridad y autorización

Se implementó la autorización por propiedad de recursos utilizando las **Policies de Laravel**.

Antes de permitir el cuidado de un árbol, el sistema verifica que pertenezca al usuario autenticado.

También se utilizan respuestas HTTP para comunicar los resultados de las solicitudes:

| Código HTTP | Significado |
|-------------|-------------|
| `200 OK` | Operación realizada correctamente. |
| `201 Created` | Usuario registrado correctamente. |
| `401 Unauthorized` | El usuario no está autenticado. |
| `403 Forbidden` | El usuario no tiene permiso para cuidar ese árbol. |
| `404 Not Found` | El árbol solicitado no existe. |
| `409 Conflict` | El cuidado no está permitido debido al estado o cooldown. |

## 3. API del Sprint 2

Las rutas nuevas de autenticación y cuidado se encuentran definidas en:

```text
routes/api.php
```

### 3.1. Rutas de autenticación

| Método | Endpoint | Descripción | Autenticación |
|--------|----------|-------------|---------------|
| POST | `/api/register` | Registrar un nuevo usuario. | No |
| POST | `/api/login` | Iniciar sesión. | No |
| GET | `/api/user` | Consultar el usuario autenticado. | Sí |
| POST | `/api/logout` | Cerrar sesión. | Sí |

Los endpoints protegidos utilizan Laravel Sanctum.

### 3.2. Endpoint de cuidado

**Método:**

```http
POST
```

**Ruta:**

```text
/api/trees/{tree}/care
```

**Autenticación requerida:**

```text
auth:sanctum
```

El endpoint recibe el identificador del árbol y verifica que pueda recibir cuidados.

#### Ejemplo de solicitud

```http
POST /api/trees/1/care
Authorization: Bearer TOKEN_DE_ACCESO
Accept: application/json
```

#### Ejemplo de respuesta exitosa

```json
{
    "message": "Cuidado aplicado con éxito",
    "tree": {
        "id": 1,
        "level": 1,
        "health": 100,
        "progress": 0,
        "status": "ACTIVE",
        "next_care_at": "2026-11-02T18:00:00Z"
    }
}
```

Los valores anteriores son ilustrativos y dependen del estado del árbol al momento del cuidado.

#### Ejemplo de error por cooldown

**Código HTTP:** `409 Conflict`

```json
{
    "message": "El árbol se encuentra en período de enfriamiento.",
    "next_care_at": "2026-11-02T18:00:00Z"
}
```

El servidor devuelve la fecha en la que será posible realizar el siguiente cuidado.

## 4. Base de datos y migraciones

Durante el Sprint 2 se verificaron las migraciones, los modelos Eloquent y las relaciones entre las entidades.

### 4.1. Relación entre usuarios y árboles

Se comprobó la relación entre los modelos `User` y `Trees`.

**En el modelo User:**

```php
public function trees()
{
    return $this->hasMany(Trees::class, 'id_user', 'id_user');
}
```

**En el modelo Trees:**

```php
public function user(): BelongsTo
{
    return $this->belongsTo(
        User::class,
        'id_user',
        'id_user'
    );
}
```

Esto establece una relación de **uno a muchos**, donde cada usuario puede tener varios árboles, pero cada árbol pertenece a un único usuario.

### 4.2. Migraciones

Se verificaron las migraciones correspondientes a las tablas principales del proyecto.

También se incorporó la tabla:

```text
personal_access_tokens
```

Esta tabla es utilizada por Laravel Sanctum para almacenar los tokens de autenticación.

Para ejecutar las migraciones pendientes:

```bash
php artisan migrate
```

Para consultar el estado de las migraciones:

```bash
php artisan migrate:status
```

Durante la verificación del Sprint 2 se comprobó la ejecución de las migraciones mediante:

```bash
php artisan migrate:fresh --database=sqlite
```

La comprobación se realizó utilizando SQLite en memoria y las nueve migraciones finalizaron correctamente.

**Importante:** `migrate:fresh` elimina todas las tablas de la base de datos seleccionada. Se recomienda utilizarlo únicamente en un entorno de pruebas aislado.

## 5. Pruebas automatizadas

Se implementaron pruebas automatizadas utilizando PHPUnit y las herramientas de testing de Laravel.

El archivo principal es:

```text
tests/Feature/TreeCareTest.php
```

Este archivo contiene **12 pruebas automatizadas** para verificar las reglas del cuidado de árboles.

### 5.1. Escenarios probados

| N.º | Prueba | Resultado esperado |
|-----|--------|--------------------|
| 1 | Cuidado exitoso | El cuidado se aplica y el progreso aumenta. |
| 2 | Bloqueo por cooldown | La segunda solicitud devuelve HTTP 409. |
| 3 | Ascenso de nivel | Después de 5 cuidados, el nivel aumenta y el progreso vuelve a 0. |
| 4 | Evolución a MATURE | Al alcanzar el nivel 10, el árbol pasa a `MATURE`. |
| 5 | Protección de recursos | Un usuario no puede cuidar árboles ajenos. |
| 6 | Árbol inexistente | Se devuelve HTTP 404. |
| 7 | Árbol DEAD | No puede recibir cuidados. |
| 8 | Árbol MATURE | No puede recibir cuidados. |
| 9 | Árbol HARVESTED | No puede recibir cuidados. |
| 10 | Recuperación de salud | Un cuidado puede recuperar 20 puntos de salud. |
| 11 | Límite de salud | La salud nunca supera los 100 puntos. |
| 12 | Cooldown exacto | El siguiente cuidado se programa 60 minutos después. |

### 5.2. Verificación de la base de datos de pruebas

También se implementó:

```text
tests/Feature/DatabaseSafetyTest.php
```

Esta prueba comprueba que PHPUnit utiliza SQLite en memoria.

La configuración de pruebas permite trabajar con una base temporal, sin utilizar los datos habituales de desarrollo.

### 5.3. Ejecutar todas las pruebas

Desde la terminal, dentro de la carpeta del proyecto, ejecutar:

```bash
php artisan test
```

### 5.4. Ejecutar únicamente las pruebas de cuidado

```bash
php artisan test --filter=TreeCareTest
```

Las 12 pruebas de cuidado de árboles se ejecutaron correctamente.

## 6. Lista de verificación de entrega

Se verificaron los requisitos establecidos en la guía del Sprint 2.

- [x] Migraciones ejecutándose correctamente mediante `migrate:fresh`.
- [x] Relaciones Eloquent entre `User` y `Trees` configuradas.
- [x] Endpoint `POST /api/trees/{tree}/care` funcional.
- [x] Validación del cooldown de 60 minutos.
- [x] Incremento de progreso y ascenso de nivel.
- [x] Transición automática al estado `MATURE`.
- [x] Autorización por propiedad mediante Policies.
- [x] Respuestas JSON y códigos HTTP correspondientes.
- [x] Pruebas automatizadas ejecutadas satisfactoriamente.

## 7. Funcionalidades pendientes

El Sprint 2 se enfocó principalmente en el backend y las reglas de cuidado de los árboles.

Para etapas posteriores quedan pendientes:

- Integración completa del backend con el frontend.
- Automatización periódica del deterioro mediante Laravel Scheduler.
- Endpoint para cosechar árboles maduros.
- Implementación de compras y catálogo de la tienda.
- Gestión funcional del inventario y utilización de ítems.
- Implementación y pruebas de las demás funcionalidades contempladas en el proyecto.

## 8. Resultado del Sprint 2

Al finalizar el Sprint 2, GreenCycle cuenta con autenticación de usuarios mediante Laravel Sanctum, autorización por propiedad de los árboles, lógica de cuidado, recuperación de salud, progreso de niveles, control de cooldown y transición al estado `MATURE`.

También se verificaron las relaciones de los modelos, las migraciones y las principales reglas de negocio mediante pruebas automatizadas.

Estos avances establecen una base para continuar con las siguientes funcionalidades del vivero digital.