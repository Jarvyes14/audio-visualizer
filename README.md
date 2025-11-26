# 🎨 Aura Experience - Audio Visualizer

Sistema completo de visualización de audio 3D interactivo con captura de screenshots y envío automático por email. Desarrollado con Laravel 11 y WebAudio API.

![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Tailwind](https://img.shields.io/badge/Tailwind-3.x-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)

## 🌟 Características

### Autenticación y Seguridad
- ✅ Sistema completo de registro y login (Laravel Breeze)
- ✅ Verificación de email
- ✅ Gestión de sesiones seguras
- ✅ Protección CSRF
- ✅ Middleware de roles personalizado

### Sistema de Roles
- 👑 **Admin**: Acceso completo, gestión de usuarios
- 👔 **Staff**: Acceso al visualizador y gestión de screenshots
- 👤 **Client**: Acceso básico al visualizador

### Visualizador de Audio 3D
- 🎵 Captura de audio desde **micrófono** o **audio del sistema**
- 🌐 Esfera 3D interactiva con 1500 partículas
- 🎨 Gradientes de color dinámicos (5 colores)
- ⚙️ Controles en tiempo real:
    - Sensibilidad de audio
    - Deformación máxima
    - Velocidad de rotación
    - Tamaño de la esfera
- 🌙 Modo oscuro completo
- 📱 Diseño responsive

### Sistema de Screenshots
- 📸 Captura instantánea del canvas
- ☁️ Almacenamiento en servidor
- 📧 Envío automático por email (asíncrono con Jobs/Queues)
- 🖼️ Galería personal de capturas
- 🔄 Opción de reenvío por email
- 💾 Descarga directa

### Panel de Administración
- 👥 CRUD completo de usuarios
- 🎭 Asignación de roles
- 🔐 Activación/desactivación de cuentas
- 📊 Listado paginado con búsqueda
- 📈 Estadísticas de screenshots por usuario

---

## 🚀 Demo en Producción

**URL**: [https://audio-visualizer-production-0e4c.up.railway.app](https://audio-visualizer-production-0e4c.up.railway.app)

**Usuarios de prueba**:
- **Admin**: `admin@audiovisualizer.com` / `password`
- **Staff**: `staff@audiovisualizer.com` / `password`
- **Client**: `john@example.com` / `password`

---

## 📋 Requisitos

- PHP 8.2+
- Composer 2.x
- Node.js 18+ y NPM
- MySQL 8.0+ / PostgreSQL 13+
- Cuenta de Gmail (para envío de emails)

---

## 🛠️ Instalación Local

### 1. Clonar el repositorio

```bash
git clone https://github.com/tu-usuario/aura-experience.git
cd aura-experience
```

### 2. Instalar dependencias

```bash
# PHP dependencies
composer install

# JavaScript dependencies
npm install
```

### 3. Configurar ambiente

```bash
# Copiar archivo de configuración
cp .env.example .env

# Generar key de aplicación
php artisan key:generate
```

### 4. Configurar base de datos

Edita `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=aura_experience
DB_USERNAME=root
DB_PASSWORD=tu_password
```

Crear la base de datos:

```sql
CREATE DATABASE aura_experience CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 5. Configurar email (Gmail)

1. Ve a [Google Account Security](https://myaccount.google.com/security)
2. Activa la **verificación en 2 pasos**
3. Ve a [App Passwords](https://myaccount.google.com/apppasswords)
4. Genera una contraseña de aplicación
5. Actualiza `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu-email@gmail.com
MAIL_PASSWORD=tu-password-de-app-de-16-caracteres
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@auraexperience.com"
MAIL_FROM_NAME="Aura Experience"
```

### 6. Ejecutar migraciones y seeders

```bash
# Ejecutar migraciones
php artisan migrate

# Ejecutar seeders (crea usuarios de prueba)
php artisan db:seed

# Crear enlace simbólico para storage
php artisan storage:link
```

### 7. Compilar assets

```bash
# Desarrollo
npm run dev

# Producción
npm run build
```

### 8. Iniciar servidores

```bash
# Servidor Laravel
php artisan serve

# Queue worker (en otra terminal)
php artisan queue:work

# Vite dev server (solo en desarrollo)
npm run dev
```

Visita: [http://localhost:8000](http://localhost:8000)

---

## 🌐 Deployment en Railway

### Configuración automática

El proyecto está configurado para deployment automático en Railway con:

- `nixpacks.toml` - Configuración de build
- `Procfile` - Comando de inicio
- `start.sh` - Script de inicialización

### Variables de entorno necesarias

```env
APP_NAME=Aura Experience
APP_ENV=production
APP_KEY=base64:tu-key-generada
APP_DEBUG=false
APP_URL=https://tu-dominio.railway.app

DB_CONNECTION=mysql
DB_HOST=${MYSQLHOST}
DB_PORT=${MYSQLPORT}
DB_DATABASE=${MYSQLDATABASE}
DB_USERNAME=${MYSQLUSER}
DB_PASSWORD=${MYSQLPASSWORD}

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu-email@gmail.com
MAIL_PASSWORD=tu-password-de-app
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@auraexperience.com
MAIL_FROM_NAME=Aura Experience

QUEUE_CONNECTION=database
SESSION_DRIVER=database
FILESYSTEM_DISK=public
```

### Pasos de deployment

1. Conecta tu repositorio de GitHub a Railway
2. Agrega un servicio MySQL
3. Configura las variables de entorno
4. Railway deployará automáticamente

---

## 📁 Estructura del Proyecto

```
aura-experience/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/
│   │   │   ├── ProfileController.php
│   │   │   ├── UserController.php
│   │   │   ├── VisualizerController.php
│   │   │   └── ScreenshotController.php
│   │   └── Middleware/
│   │       └── CheckRole.php
│   ├── Jobs/
│   │   └── SendScreenshotEmail.php
│   ├── Mail/
│   │   └── ScreenshotMail.php
│   └── Models/
│       ├── User.php
│       ├── Role.php
│       └── Screenshot.php
├── database/
│   ├── migrations/
│   │   └── xxxx_create_roles_and_screenshots_tables.php
│   └── seeders/
│       └── DatabaseSeeder.php
├── public/
│   ├── screenshots/          # Imágenes capturadas
│   └── intro/                # Video y audio de bienvenida
├── resources/
│   ├── css/
│   │   └── app.css
│   ├── js/
│   │   └── app.js
│   └── views/
│       ├── admin/
│       │   └── users/
│       ├── emails/
│       │   └── screenshot.blade.php
│       ├── screenshots/
│       │   └── index.blade.php
│       ├── visualizer/
│       │   └── index.blade.php
│       ├── dashboard.blade.php
│       └── welcome.blade.php
├── routes/
│   └── web.php
├── start.sh                  # Script de inicio para Railway
├── nixpacks.toml            # Configuración de Railway
├── Procfile                 # Comando de inicio
├── composer.json
├── package.json
└── vite.config.js
```

---

## 🎮 Uso

### Para Clientes

1. **Registrarse** en la aplicación
2. **Login** con credenciales
3. Ir a **"Visualizer"** desde el dashboard
4. Seleccionar fuente de audio:
    - 🎤 **Micrófono**: Para capturar tu voz
    - 🔊 **Audio del sistema**: Para capturar música/videos
5. Ajustar parámetros con los sliders
6. Click en **"📸 Capturar & Enviar"** para guardar
7. Ver capturas en **"My Screenshots"**

### Para Administradores

1. Login con cuenta de admin
2. Acceder a **"User Management"**
3. Gestionar usuarios:
    - ➕ Crear nuevos usuarios
    - ✏️ Editar información
    - 🔐 Activar/desactivar cuentas
    - 🎭 Asignar roles
    - 🗑️ Eliminar usuarios

---

## 🔐 Roles y Permisos

| Característica | Admin | Staff | Client |
|----------------|-------|-------|--------|
| Usar visualizador | ✅ | ✅ | ✅ |
| Capturar screenshots | ✅ | ✅ | ✅ |
| Ver galería propia | ✅ | ✅ | ✅ |
| Gestionar usuarios | ✅ | ❌ | ❌ |
| Asignar roles | ✅ | ❌ | ❌ |
| Acceder panel admin | ✅ | ❌ | ❌ |

---

## 🎨 Características Técnicas

### Frontend
- **Tailwind CSS 3.x** - Estilos utility-first
- **Alpine.js** (via Breeze) - Interactividad
- **Vite** - Build tool moderno
- **WebAudio API** - Análisis de audio en tiempo real
- **Canvas API** - Renderizado 3D
- **Modo oscuro** nativo

### Backend
- **Laravel 11** - Framework PHP moderno
- **Laravel Breeze** - Autenticación simple
- **Jobs & Queues** - Procesamiento asíncrono
- **Eloquent ORM** - Interacción con BD
- **Mail System** - Envío de emails
- **Middleware personalizado** - Control de acceso

### Base de Datos
- **MySQL 8.0+** / PostgreSQL
- Migraciones versionadas
- Seeders para datos iniciales
- Relaciones many-to-many para roles

---

## 📧 Sistema de Email

### Características
- ✅ Envío asíncrono (no bloquea la app)
- ✅ Reintentos automáticos (3 intentos)
- ✅ Timeout de 120 segundos
- ✅ Logs detallados
- ✅ Email HTML responsive
- ✅ Adjunto de imagen PNG

### Template del Email
El email incluye:
- Saludo personalizado
- Detalles del screenshot
- Imagen adjunta (PNG)
- Enlace a la galería
- Diseño responsive con gradientes

---

## 🐛 Troubleshooting

### Error: "Vite manifest not found"
```bash
npm run build
git add -f public/build/
git commit -m "fix: include vite build"
git push
```

### Error: "CSRF token mismatch"
1. Limpiar caché: `php artisan config:clear`
2. Recargar la página completamente (Ctrl+F5)

### Error: "Screenshot email timeout"
- El email se envía en background con Jobs
- Verificar que el queue worker esté corriendo
- Revisar credenciales de Gmail

### Screenshots no aparecen (404)
```bash
php artisan storage:link
chmod -R 775 public/screenshots
```

### Permisos en producción
```bash
chmod -R 775 storage bootstrap/cache public/screenshots
```

---

## 🔧 Comandos Útiles

```bash
# Limpiar caché
php artisan optimize:clear

# Ver rutas
php artisan route:list

# Ver logs en tiempo real
tail -f storage/logs/laravel.log

# Procesar cola manualmente
php artisan queue:work --tries=3

# Crear nuevo usuario admin
php artisan tinker
>>> $user = User::create(['name' => 'Admin', 'email' => 'admin@example.com', 'password' => Hash::make('password'), 'is_active' => true]);
>>> $user->roles()->attach(Role::where('name', 'admin')->first()->id);
>>> exit

# Resetear base de datos
php artisan migrate:fresh --seed
```

---

## 📝 Git Commits (Buenas Prácticas)

El proyecto sigue conventional commits:

```bash
feat: add new feature
fix: bug fix
docs: documentation changes
style: code style changes
refactor: code refactoring
test: add tests
chore: maintenance tasks
```

---

## 🚀 Roadmap

- [ ] Agregar más formas 3D (cubo, toroide, plano)
- [ ] Sistema de favoritos para screenshots
- [ ] Compartir capturas por redes sociales
- [ ] Temas de color personalizables
- [ ] Exportar video de la visualización
- [ ] Integración con Spotify/Apple Music
- [ ] Sistema de comentarios en capturas
- [ ] Galería pública (opcional)

---

## 🤝 Contribución

Las contribuciones son bienvenidas. Por favor:

1. Fork el proyecto
2. Crea una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'feat: add amazing feature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

---

## 📄 Licencia

Este proyecto está bajo la licencia MIT. Ver el archivo `LICENSE` para más detalles.

---

## 👨‍💻 Autor

**Javier Barceló Santos**
- Website: [javierbarcelosantos.dev](https://javierbarcelosantos.dev)
- Email: [aura.experience.magic@gmail.com](mailto:aura.experience.magic@gmail.com)

---

## 🙏 Agradecimientos

- [Laravel](https://laravel.com) - Framework PHP
- [Tailwind CSS](https://tailwindcss.com) - Framework CSS
- [Railway](https://railway.app) - Hosting
- [WebAudio API](https://developer.mozilla.org/en-US/docs/Web/API/Web_Audio_API) - Audio processing
- [Canvas API](https://developer.mozilla.org/en-US/docs/Web/API/Canvas_API) - 3D rendering

---

## 📸 Screenshots

### Página de Bienvenida
![Welcome](docs/screenshots/welcome.png)

### Visualizador 3D
![Visualizer](docs/screenshots/visualizer.png)

### Galería de Screenshots
![Gallery](docs/screenshots/gallery.png)

### Panel de Administración
![Admin Panel](docs/screenshots/admin.png)

### Email Recibido
![Email](docs/screenshots/email.png)

---

**Desarrollado con ❤️ usando Laravel y WebAudio API**

⭐ **Si te gusta el proyecto, dale una estrella en GitHub!**
