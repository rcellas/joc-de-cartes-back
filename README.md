# Joc de Cartes - API Backend

API REST backend para la gestión de restaurantes que participaron en el programa de TV3 "Joc de cartes".

## 📋 Descripción

Este proyecto es una API desarrollada con Laravel 12 que permite gestionar la información de los restaurantes que han participado en el popular programa de televisión de TV3 "Joc de cartes". La aplicación permite almacenar y consultar datos sobre los restaurantes, los programas emitidos y la relación entre ambos.

## ✨ Características

- 🍽️ Gestión completa de restaurantes (CRUD)
- 📺 Gestión de programas y temporadas
- 🔗 Relación many-to-many entre programas y restaurantes
- 🔐 Autenticación JWT
- 📍 Almacenamiento de geolocalización de restaurantes
- 👥 Sistema de roles de usuario (admin/user)

## 🛠️ Tecnologías

- **Framework:** Laravel 12
- **PHP:** ^8.2
- **Base de datos:** SQLite (por defecto) / MySQL / PostgreSQL
- **Autenticación:** JWT (php-open-source-saver/jwt-auth)
- **Frontend (opcional):** Vite + TailwindCSS 4

## 📦 Requisitos previos

- PHP >= 8.2
- Composer
- SQLite / MySQL / PostgreSQL
- Node.js y npm (para el frontend)

## 🚀 Instalación

1. **Clonar el repositorio:**
```bash
git clone https://github.com/rcellas/joc-de-cartes-back.git
cd joc-de-cartes-back
```

2. **Instalar dependencias de PHP:**
```bash
composer install
```

3. **Copiar el archivo de configuración:**
```bash
cp .env.example .env
```

4. **Generar la clave de aplicación:**
```bash
php artisan key:generate
```

5. **Generar la clave secreta de JWT:**
```bash
php artisan jwt:secret
```

6. **Configurar la base de datos:**

Por defecto, el proyecto usa SQLite. Si deseas usar MySQL o PostgreSQL, modifica el archivo `.env`:

```env
DB_CONNECTION=sqlite
```

Para MySQL:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=joc_de_cartes
DB_USERNAME=root
DB_PASSWORD=
```

7. **Crear la base de datos (si usas SQLite):**
```bash
touch database/database.sqlite
```

8. **Ejecutar las migraciones:**
```bash
php artisan migrate
```

9. **Poblar la base de datos (opcional):**
```bash
php artisan db:seed
```

10. **Instalar dependencias de Node.js (opcional, para frontend):**
```bash
npm install
```

## 🎯 Uso

### Iniciar el servidor de desarrollo

```bash
php artisan serve
```

La API estará disponible en `http://localhost:8000`

### Compilar assets (si se usa frontend)

```bash
# Desarrollo
npm run dev

# Producción
npm run build
```

## 🔌 Endpoints de la API

### Autenticación

| Método | Endpoint | Descripción | Autenticación |
|--------|----------|-------------|---------------|
| POST | `/api/auth/register` | Registrar nuevo usuario | No |
| POST | `/api/auth/login` | Iniciar sesión | No |
| POST | `/api/auth/logout` | Cerrar sesión | Sí |
| POST | `/api/auth/refresh` | Refrescar token | Sí |
| POST | `/api/auth/me` | Obtener usuario autenticado | Sí |

**Ejemplo de registro:**
```json
POST /api/auth/register
{
  "name": "Juan Pérez",
  "email": "juan@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}
```

**Ejemplo de login:**
```json
POST /api/auth/login
{
  "email": "juan@example.com",
  "password": "password123"
}
```

### Restaurantes

| Método | Endpoint | Descripción | Autenticación |
|--------|----------|-------------|---------------|
| GET | `/restaurants` | Listar todos los restaurantes | No |
| GET | `/restaurants/{id}` | Obtener un restaurante | No |
| POST | `/restaurants` | Crear un restaurante | No |
| PUT | `/restaurants/{id}` | Actualizar un restaurante | No |
| DELETE | `/restaurants/{id}` | Eliminar un restaurante | No |

**Estructura de un restaurante:**
```json
{
  "id": 1,
  "name": "El Celler de Can Roca",
  "address": "Can Sunyer, 48",
  "city": "Girona",
  "province": "Girona",
  "postal_code": "17007",
  "latitude": 41.9794,
  "longitude": 2.8214,
  "created_at": "2025-03-11T22:37:16.000000Z",
  "updated_at": "2025-03-11T22:37:16.000000Z"
}
```

### Programas

| Método | Endpoint | Descripción | Autenticación |
|--------|----------|-------------|---------------|
| GET | `/api/programs` | Listar todos los programas | No |
| GET | `/api/programs/{id}` | Obtener un programa con sus restaurantes | No |
| POST | `/api/programs` | Crear un programa | Sí (Admin) |
| PUT | `/api/programs/{id}` | Actualizar un programa | Sí (Admin) |
| DELETE | `/api/programs/{id}` | Eliminar un programa | Sí (Admin) |

**Estructura de un programa:**
```json
{
  "id": 1,
  "name": "Joc de Cartes - Especial Girona",
  "description": "Ruta gastronómica por Girona",
  "year": 2024,
  "season": 12,
  "created_at": "2025-03-11T23:07:40.000000Z",
  "updated_at": "2025-03-11T23:07:40.000000Z",
  "restaurants": [
    {
      "id": 1,
      "name": "El Celler de Can Roca",
      ...
    }
  ]
}
```

## 🔐 Autenticación con JWT

Para acceder a los endpoints protegidos, debes incluir el token JWT en el header:

```bash
Authorization: Bearer {tu-token-jwt}
```

Ejemplo con cURL:
```bash
curl -X POST http://localhost:8000/api/programs \
  -H "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGc..." \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Joc de Cartes - Barcelona",
    "description": "Especial Barcelona",
    "year": 2024,
    "season": 13
  }'
```

## 📁 Estructura del proyecto

```
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── AuthController.php      # Autenticación JWT
│   │       ├── ProgramController.php   # Gestión de programas
│   │       └── RestaurantController.php # Gestión de restaurantes
│   └── Models/
│       ├── Program.php                  # Modelo de programa
│       ├── Restaurant.php               # Modelo de restaurante
│       └── User.php                     # Modelo de usuario
├── database/
│   ├── migrations/                      # Migraciones de la base de datos
│   └── seeders/                         # Seeders para datos de prueba
├── routes/
│   ├── api.php                          # Rutas de la API
│   └── web.php                          # Rutas web
└── config/
    ├── auth.php                         # Configuración de autenticación
    └── database.php                     # Configuración de base de datos
```

## 🗄️ Modelo de datos

### Restaurantes
- `id`: Identificador único
- `name`: Nombre del restaurante
- `address`: Dirección
- `city`: Ciudad
- `province`: Provincia
- `postal_code`: Código postal
- `latitude`: Latitud (coordenadas GPS)
- `longitude`: Longitud (coordenadas GPS)

### Programas
- `id`: Identificador único
- `name`: Nombre del programa
- `description`: Descripción
- `year`: Año de emisión
- `season`: Número de temporada

### Relación
Los programas y restaurantes tienen una relación **many-to-many**, permitiendo que un programa tenga múltiples restaurantes y un restaurante pueda aparecer en múltiples programas.

## 👥 Sistema de roles

El proyecto incluye un sistema de roles básico:
- **Admin:** Puede crear, actualizar y eliminar programas
- **User:** Puede consultar información

## 🧪 Testing

```bash
php artisan test
```

## 📝 Licencia

Este proyecto es de código abierto.

## 👨‍💻 Autor

[@rcellas](https://github.com/rcellas)

## 🤝 Contribuir

Las contribuciones son bienvenidas. Por favor, abre un issue o pull request para sugerencias o mejoras.
