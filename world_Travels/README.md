# WORLD TRAVELS - Aplicación Web de Turismo en Boyacá

Una aplicación web completa para la gestión de actividades turísticas en el departamento de Boyacá, Colombia. Desarrollada con Laravel 11, JWT para autenticación, y un sistema de roles robusto.

## 🚀 Características Principales

### Sistema de Autenticación y Roles
- **Turista**: Puede explorar actividades, hacer reservas y dejar reseñas
- **Guía Turístico**: Puede crear y gestionar sus propias actividades turísticas
- **Administrador**: Control total del sistema, gestión de usuarios y contenido

### Funcionalidades
- ✅ Registro e inicio de sesión seguro con JWT
- ✅ Gestión completa de actividades turísticas
- ✅ Sistema de reservas y calificaciones
- ✅ Dashboard personalizado por rol
- ✅ Interfaz responsiva y moderna
- ✅ API REST completa
- ✅ Validaciones de datos robustas

## 🛠️ Tecnologías Utilizadas

- **Backend**: Laravel 11 (PHP 8.2+)
- **Base de Datos**: MySQL
- **Autenticación**: JWT (JSON Web Tokens)
- **Frontend**: Blade Templates + JavaScript
- **Estilos**: Tailwind CSS
- **Arquitectura**: MVC con API REST

## 📋 Requisitos del Sistema

- PHP 8.2 o superior
- Composer
- MySQL 8.0+
- Node.js y npm (para assets)
- XAMPP o similar (para desarrollo local)

## 🚀 Instalación y Configuración

### 1. Clonar el repositorio
```bash
git clone <url-del-repositorio>
cd world-travels
```

### 2. Instalar dependencias de PHP
```bash
composer install
```

### 3. Instalar dependencias de Node.js
```bash
npm install
```

### 4. Configurar el archivo .env
```bash
cp .env.example .env
```

Editar el archivo `.env` con la configuración de tu base de datos:
```env
APP_NAME="WORLD TRAVELS"
APP_ENV=local
APP_KEY=base64:tu-app-key-aqui
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=world_travels
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña

JWT_SECRET=tu-jwt-secret-aqui
```

### 5. Generar clave de aplicación
```bash
php artisan key:generate
```

### 6. Ejecutar migraciones y seeders
```bash
php artisan migrate:fresh --seed
```

### 7. Compilar assets (opcional para desarrollo)
```bash
npm run build
# o para desarrollo con hot reload
npm run dev
```

### 8. Iniciar el servidor
```bash
php artisan serve
```

La aplicación estará disponible en: `http://localhost:8000`

## 📊 Estructura de la Base de Datos

### Tablas Principales
- `usuarios` - Usuarios del sistema con roles
- `departamentos` - Departamentos de Colombia
- `municipios` - Municipios pertenecientes a departamentos
- `categorias__actividades` - Categorías de actividades turísticas
- `actividades` - Actividades turísticas disponibles
- `reservas` - Reservas realizadas por usuarios
- `comentarios` - Comentarios y calificaciones de actividades

### Roles del Sistema
1. **Turista** - Usuario final que consume servicios
2. **Guía Turístico** - Usuario que crea y gestiona actividades
3. **Administrador** - Usuario con control total del sistema

## 🔐 API Endpoints

### Autenticación
- `POST /api/registrar` - Registro de usuario
- `POST /api/login` - Inicio de sesión
- `POST /api/logout` - Cierre de sesión
- `GET /api/me` - Información del usuario autenticado

### Gestión de Usuarios (Admin)
- `GET /api/listarUsuarios` - Listar todos los usuarios
- `POST /api/crearUsuarios` - Crear usuario
- `GET /api/usuarios/{id}` - Obtener usuario específico
- `PUT /api/actualizarUsuarios/{id}` - Actualizar usuario
- `DELETE /api/eliminarUsuarios/{id}` - Eliminar usuario

### Actividades
- `GET /api/listarActividades` - Listar todas las actividades
- `POST /api/crearActividades` - Crear actividad (Guía/Admin)
- `GET /api/actividades/{id}` - Obtener actividad específica
- `PUT /api/actualizarActividades/{id}` - Actualizar actividad
- `DELETE /api/eliminarActividades/{id}` - Eliminar actividad

### Reservas
- `GET /api/listarReservas` - Listar todas las reservas
- `POST /api/crearReservas` - Crear reserva
- `GET /api/reservas/{id}` - Obtener reserva específica
- `PUT /api/actualizarReservas/{id}` - Actualizar reserva
- `DELETE /api/eliminarReservas/{id}` - Eliminar reserva

### Comentarios
- `GET /api/listarComentarios` - Listar todos los comentarios
- `POST /api/crearComentarios` - Crear comentario
- `GET /api/comentarios/{id}` - Obtener comentario específico
- `PUT /api/actualizarComentarios/{id}` - Actualizar comentario
- `DELETE /api/eliminarComentarios/{id}` - Eliminar comentario

## 🎨 Interfaz de Usuario

### Páginas Disponibles
- **Inicio** (`/`) - Página principal con actividades destacadas
- **Buscar Actividades** (`/search`) - Búsqueda y filtrado de actividades
- **Iniciar Sesión** (`/login`) - Autenticación de usuarios
- **Registro** (`/register`) - Registro de nuevos usuarios
- **Dashboard** (`/dashboard`) - Panel de control personalizado por rol

### Diseño Responsivo
- Compatible con dispositivos móviles, tablets y desktop
- Diseño moderno con Tailwind CSS
- Elementos visuales inspirados en viajes y turismo

## 🔒 Seguridad

- **Encriptación de contraseñas** con bcrypt
- **Autenticación JWT** para APIs
- **Validaciones** robustas en todos los formularios
- **Protección CSRF** en formularios web
- **Middleware de roles** para control de acceso
- **Validaciones de entrada** para prevenir inyección SQL

## 🧪 Pruebas

### Ejecutar pruebas
```bash
php artisan test
```

### Pruebas incluidas
- Pruebas unitarias de modelos
- Pruebas de integración de API
- Pruebas de autenticación
- Pruebas de validaciones

## 📈 Despliegue

### Requisitos para producción
- Servidor web (Apache/Nginx)
- PHP 8.2+
- MySQL 8.0+
- SSL Certificate (recomendado)

### Pasos de despliegue
1. Configurar variables de entorno para producción
2. Ejecutar migraciones en el servidor
3. Configurar permisos de archivos
4. Configurar SSL
5. Optimizar assets para producción

## 🤝 Contribución

1. Fork el proyecto
2. Crea una rama para tu feature (`git checkout -b feature/nueva-funcionalidad`)
3. Commit tus cambios (`git commit -am 'Agrega nueva funcionalidad'`)
4. Push a la rama (`git push origin feature/nueva-funcionalidad`)
5. Abre un Pull Request

## 📝 Licencia

Este proyecto está bajo la Licencia MIT. Ver el archivo `LICENSE` para más detalles.

## 📞 Soporte

Para soporte técnico o preguntas:
- Crear un issue en el repositorio
- Contactar al equipo de desarrollo

## 🔄 Próximas Funcionalidades

- [ ] Notificaciones en tiempo real con WebSockets
- [ ] Sistema de pagos integrado
- [ ] Mapas interactivos con Google Maps
- [ ] Galería de fotos para actividades
- [ ] Sistema de recomendaciones basado en IA
- [ ] API móvil para aplicaciones nativas
- [ ] Integración con redes sociales
- [ ] Sistema de cupones y descuentos

---

**Desarrollado con ❤️ para promover el turismo en Boyacá, Colombia**
