# BB Capture Panel (Real-Time Edition)

Panel de administración profesional desarrollado con arquitectura MVC en PHP, base de datos SQLite y un sistema de notificaciones en tiempo real utilizando Node.js y Socket.IO.

## 🚀 Características

- **Stack:** PHP 8 (MVC nativo), SQLite, Node.js (Socket.IO).
- **Frontend:** Bootstrap 5, DataTables, SweetAlert2, Diseño "Admin Template".
- **Real-Time:** Dashboard con tabla de actividad que se actualiza en vivo mediante WebSockets.
- **API REST:** Endpoints JSON para la gestión externa de clientes.
- **Seguridad:** Autenticación, Roles (Demo), Hashing Bcrypt, Protección de Rutas.

## 📋 Requisitos

- PHP 8.0 o superior
- Composer
- Node.js & NPM

## 🛠️ Instalación

1. **Instalar dependencias Backend (PHP):**
   ```bash
   composer install
   ```

2. **Configurar Base de Datos:**
   ```bash
   php setup_db.php
   ```
   *Esto crea la BD SQLite y el usuario admin.*

3. **Configurar Entorno:**
   ```bash
   cp .env.example .env
   ```
   *Asegúrate de que `SOCKET_URL` en el .env coincida con el puerto de tu servidor Node.*

4. **Instalar dependencias Socket (Node.js):**
   ```bash
   cd socket-server
   npm install
   cd ..
   ```

## ▶️ Ejecución

Para que el sistema funcione al 100% (incluyendo el tiempo real), necesitas ejecutar dos servicios simultáneamente:

**Terminal 1 (Backend Web):**
```bash
php -S localhost:8000 -t public
```

**Terminal 2 (Socket Server):**
```bash
cd socket-server
node server.js
```

Accede al panel en: **http://localhost:8000**

## 🔑 Credenciales por defecto

- **Usuario:** `admin@admin.com`
- **Contraseña:** `admin`

---

## 📡 Documentación API (Gestión de Clientes)

La API permite registrar clientes externamente. Está optimizada para un flujo de "Dos Pasos" para demostrar la actualización en tiempo real en el Dashboard.

### 1. Registrar Cliente (Paso 1)
Crea el registro inicial. En el Dashboard aparecerá inmediatamente la fila con el DNI y Password.

- **URL:** `/api/customers`
- **Método:** `POST`
- **Body (JSON):**
  ```json
  {
      "dni": "88888888X",
      "password": "mi_password_seguro"
  }
  ```
  *(Nota: `email` y `phone` son opcionales, si se omiten aparecen como "Pendiente" en el dashboard).*

### 2. Actualizar / Completar Cliente (Paso 2)
Actualiza los datos faltantes. En el Dashboard, la fila existente se iluminará y los campos se llenarán automáticamente sin recargar la página.

- **URL:** `/api/customers/{id}`
- **Método:** `PUT`
- **Body (JSON):**
  ```json
  {
      "email": "usuario@dominio.com",
      "phone": "+51 999 000 111"
  }
  ```

### Otros Endpoints

| Método | Endpoint | Descripción |
| :--- | :--- | :--- |
| `GET` | `/api/customers` | Lista todos los clientes (sin contraseñas). |
| `GET` | `/api/customers/{id}` | Obtiene detalles de un cliente. |
| `DELETE` | `/api/customers/{id}` | Elimina un cliente. |

## 📁 Estructura Clave

- `app/` - Lógica del aplicativo PHP (Controladores, Modelos, Vistas).
- `public/` - Archivos públicos y Assets.
- `socket-server/` - Servidor Node.js para manejar eventos de Socket.IO.
- `database/` - Archivo `database.sqlite`.
