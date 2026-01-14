# BB Capture Panel

Panel de administración simple con MVC, PHP y SQLite, incluyendo API REST para gestión de clientes.

## Requisitos
- PHP 8.0 o superior
- Composer

## Instalación

1. Instalar dependencias:
   ```bash
   composer install
   ```

2. Configurar base de datos (automático):
   ```bash
   php setup_db.php
   ```

## Ejecución

Para iniciar el servidor de desarrollo:

```bash
php -S localhost:8000 -t public
```

---

## API Documentation (Gestión de Clientes)

El sistema expone endpoints JSON bajo el prefijo `/api/customers`.

### 1. Listar Clientes
Obtiene todos los clientes registrados.

- **URL:** `/api/customers`
- **Método:** `GET`
- **Respuesta Exitosa:**
  ```json
  {
      "success": true,
      "data": [
          { "id": 1, "dni": "12345", "email": "client@test.com", ... }
      ]
  }
  ```

### 2. Obtener un Cliente
- **URL:** `/api/customers/{id}`
- **Método:** `GET`

### 3. Crear Cliente
Registra un nuevo cliente. La contraseña será encriptada automáticamente.

- **URL:** `/api/customers`
- **Método:** `POST`
- **Body (JSON):**
  ```json
  {
      "dni": "12345678A",
      "password": "mi_password_seguro",
      "email": "opcional@email.com",
      "phone": "+34 600 000 000"
  }
  ```
  *Nota: Solo `dni` y `password` son obligatorios.*

### 4. Actualizar Cliente
- **URL:** `/api/customers/{id}`
- **Método:** `PUT`
- **Body (JSON):** (Enviar solo los campos a modificar)
  ```json
  {
      "email": "nuevo@email.com",
      "phone": "999999999"
  }
  ```

### 5. Eliminar Cliente
- **URL:** `/api/customers/{id}`
- **Método:** `DELETE`

---

## Credenciales Panel

- **Usuario:** `admin@admin.com`
- **Contraseña:** `admin`