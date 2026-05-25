# VELZON - Laravel Application

A modern Laravel application built with Bootstrap 5, DataTables, Livewire, and Spatie Permissions.

## 📋 Requirements

- PHP >= 8.2
- Composer
- Node.js >= 18.x
- NPM or Yarn
- MySQL >= 5.7 or MariaDB >= 10.3
- Apache/Nginx web server

## 🚀 Installation

### 1. Clone the Repository

```bash
git clone https://github.com/codant-one/velzon.git
cd velzon
```

### 2. Install PHP Dependencies

```bash
composer install
```

If you encounter platform requirements issues, use:

```bash
composer install --ignore-platform-reqs
```

Or specifically:

```bash
composer install --ignore-platform-req=ext-pcntl --ignore-platform-req=ext-posix
```

### 3. Install Node Dependencies

```bash
npm install
```

### 4. Environment Configuration

Copy the example environment file and configure your settings:

```bash
cp .env.example .env
```

Update the following variables in your `.env` file:

```env
APP_NAME='VELZON'
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=velzon
DB_USERNAME=root
DB_PASSWORD=

# Default Country ID
COUNTRY_ID=231

# Google Maps API Key
API_KEY_GOOGLE_MAPS='your_google_maps_api_key'

# Timezone
timezone=America/Caracas

# Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=your_mail_host
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_email@example.com
MAIL_FROM_NAME="${APP_NAME}"
```

### 5. Generate Application Key

```bash
php artisan key:generate
```

### 6. Create Database

Create a new MySQL database named `velzon` (or whatever you specified in DB_DATABASE).

### 7. Run Migrations

```bash
php artisan migrate
```

### 8. Seed Database

```bash
php artisan db:seed
```

### 9. Create Storage Link

```bash
php artisan storage:link
```

### 10. Build Assets

For development:

```bash
npm run dev
```

For production:

```bash
npm run build
```

### 11. Start Development Server

```bash
php artisan serve
```

Visit `http://localhost:8000` in your browser.

## 📦 Key Packages

### Backend
- **Laravel Framework** (v12.x) - PHP framework
- **Spatie Laravel Permission** (v6.23) - Role and permission management
- **Livewire** (v3.7) - Dynamic components
- **Laravel Sanctum** (v4.0) - API authentication
- **Laravel UI** (v4.2) - Authentication scaffolding
- **Google2FA Laravel** (v2.2) - Two-factor authentication
- **Jenssegers Agent** (v2.6) - User agent detection

### Frontend
- **Bootstrap** (v5.3.3) - UI framework
- **DataTables** (v1.11.5) - Advanced table features
- **Select2** (v4.1.0-rc.0) - Enhanced select boxes
- **Flatpickr** (v4.6.13) - Date picker
- **Toastify JS** (v1.12.0) - Toast notifications
- **SweetAlert2** (v11.6.13) - Beautiful alerts
- **Choices.js** (v10.2.0) - Select enhancement
- **Dropzone** (v6.0.0-beta.2) - File uploads
- **Prism.js** (v1.29.0) - Code syntax highlighting
- **Vite** (v5.0.12) - Build tool

## 🔧 Development Commands

### Composer

```bash
# Dump autoload
composer dump-autoload

# Install dependencies
composer install

# Update dependencies
composer update
```

### Artisan

```bash
# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# List scheduled tasks
php artisan schedule:list

# Run scheduled tasks locally
php artisan schedule:work

# Process queue jobs
php artisan queue:work

# Listen to queue (auto-reload on code changes)
php artisan queue:listen

# Create Livewire component
php artisan make:livewire ComponentName

# Run migrations for specific path
php artisan migrate --path=database/migrations/tenant

# Create migration for specific path
php artisan make:migration create_posts_table --path=database/migrations/tenant
```

### NPM

```bash
# Development build with hot reload
npm run dev

# Production build
npm run build

# Clean build directory
npm run clean

# Build RTL CSS
npm run build-rtl
```

## 📁 Project Structure

```
velzon/
├── app/
│   ├── Console/         # Console commands
│   ├── Exceptions/      # Exception handlers
│   ├── Extras/          # Utility classes (FileManager, Utils)
│   ├── Http/
│   │   ├── Controllers/ # Application controllers
│   │   ├── Middleware/  # Custom middleware
│   │   └── Kernel.php
│   ├── Livewire/        # Livewire components
│   ├── Models/          # Eloquent models
│   ├── Providers/       # Service providers
│   └── Traits/          # Reusable traits
├── bootstrap/           # Bootstrap files
├── config/              # Configuration files
├── database/
│   ├── factories/       # Model factories
│   ├── migrations/      # Database migrations
│   └── seeders/         # Database seeders
├── lang/                # Translations (ae, ch, en, fr, gr, it, ru, sp)
├── public/              # Public assets
│   ├── build/          # Compiled assets
│   ├── custom/         # Custom assets
│   └── images/         # Images
├── resources/
│   ├── fonts/          # Font files
│   ├── images/         # Source images
│   ├── js/             # JavaScript files
│   ├── json/           # JSON data files
│   ├── scss/           # SASS stylesheets
│   └── views/          # Blade templates
├── routes/
│   ├── api.php         # API routes
│   ├── channels.php    # Broadcast channels
│   ├── console.php     # Console routes
│   ├── template.php    # Template routes
│   └── web.php         # Web routes
├── storage/            # Storage directory
├── tests/              # Test files
└── vendor/             # Composer dependencies
```

## 🔐 Authentication & Authorization

The application uses:
- Laravel's built-in authentication
- Spatie Laravel Permission for roles and permissions
- Google2FA for two-factor authentication
- Laravel Sanctum for API authentication

## 🌐 Multi-language Support

Supported languages:
- English (en)
- Spanish (sp)
- French (fr)
- German (gr)
- Italian (it)
- Russian (ru)
- Chinese (ch)
- Arabic (ae)

## 📊 Database Features

- User management with detailed profiles
- Role-based access control (RBAC)
- Permission system (custom and system permissions)
- Geographic data (Countries, Provinces/States, Cities)
- Address management with Google Maps integration
- User login tracking
- Password reset functionality
- User registration tokens

## 🎨 UI Features

- Modern Bootstrap 5 design
- Responsive layout
- DataTables with server-side processing
- Advanced select boxes with Select2
- Date pickers with Flatpickr
- Toast notifications with Toastify
- Beautiful alerts with SweetAlert2
- Drag & drop file uploads with Dropzone
- Google Maps integration
- Dark/Light theme support

## 🚨 Troubleshooting

### Composer Issues

If you encounter platform requirement errors:

```bash
composer install --ignore-platform-reqs
```

### Permission Issues

If you have file permission issues:

```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### Asset Issues

If assets are not loading:

```bash
npm run clean
npm install
npm run build
php artisan cache:clear
```

### Database Issues

If migrations fail:

```bash
php artisan migrate:fresh --seed
```

**Warning:** This will drop all tables and re-run migrations.

## 📝 License

This project is proprietary software. All rights reserved.

## 👥 Credits

- **Framework:** Laravel
- **Theme:** Velzon (Themesbrand)
- **Developer:** CODANT

## 📞 Support

For support, please contact the development team at CODANT.

---

**Last Updated:** November 2025