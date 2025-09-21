# 🚀 INNOFORUM

**Ignite Innovation, Connect Minds, Shape the Future**  

[![Last Commit](https://img.shields.io/github/last-commit/FrederiyPatria/INNOFORUM)](https://github.com/FrederiyPatria/INNOFORUM/commits/main)
![Languages](https://img.shields.io/github/languages/count/FrederiyPatria/INNOFORUM)
![Repo Size](https://img.shields.io/github/repo-size/FrederiyPatria/INNOFORUM)

A comprehensive academic discussion forum built with Laravel, designed specifically for Indonesian educational institutions to foster community engagement between students and lecturers.

Built with modern tools & technologies:  
`Laravel` · `PHP` · `Composer` · `JavaScript` · `Vite` · `TailwindCSS` · `Axios` · `Excalidraw`

---

## 📖 Table of Contents
- [Overview](#-overview)
- [Features](#-features)
- [Prerequisites](#prerequisites)
- [Installation](#installation)
- [Project Structure](#project-structure)
- [Usage Guide](#usage-guide)
- [Configuration](#configuration)
- [Development](#development)
- [Troubleshooting](#troubleshooting)
- [Contributing](#contributing)
- [Team](#team)
- [License](#license)
- [Support](#support)
- [Roadmap](#Roadmap)
- [Acknowledgments](#Acknowledgments)
- [Screenshots](#-screenshots)
---

## 🔎 Overview
**INNOFORUM** is a feature-rich discussion platform that facilitates academic discussions and knowledge sharing within campus communities. The system supports role-based access control, real-time notifications, content moderation, and comprehensive user management.

---

## ✨ Features
- **Role-Based Access Control** - Secure and tailored user permissions for Students, Lecturers, and Admins
- **Admin Dashboard & Analytics** - Insightful statistics to monitor platform activity & growth
- **Thread Management System** - Create, edit, and categorize discussion threads with hashtag support
- **Interactive Comment System** - Rich commenting with image uploads and user mentions
- **Real-Time Notification System** - Stay updated on likes, comments, mentions, and announcements
- **OTP Email Verification** - Secure registration process with email verification
- **Content Moderation Tools** - Report system and admin moderation capabilities
- **Comprehensive Search** - Advanced search functionality with filters
- **Modern Frontend & Backend Integration** - Powered by Vite, Tailwind CSS, Alpine.js

---

## 📋 Prerequisites

Before installation, ensure you have:

- **PHP 8.2** or higher
- **Composer** - PHP dependency manager
- **Node.js & NPM** - For frontend asset compilation
- **SQLite** - Default database (configurable to MySQL/PostgreSQL)
- **Web Server** - Apache/Nginx or use Laravel's built-in server

---

## 🚀 Installation
### 1. Clone Repository
```bash
git clone https://github.com/SmileyTherow/INNOFORUM.git
```

### 2. Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```
### 3. Environment Setup
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Create SQLite database file (if using SQLite)
touch database/database.sqlite
```
### 4. EnviConfigure Environment
Edit .env file with your settings:
```bash
APP_NAME=INNOFORUM
APP_ENV=local
APP_KEY=base64:your-generated-key
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database Configuration (SQLite default)
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database/database.sqlite

# Mail Configuration (required for OTP)
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```
### 5. Database Migration
```bash
# Run migrations
php artisan migrate

# (Optional) Seed with sample data
php artisan db:seed
```
### 6. Build Assets
```bash
# Development build with hot reload
npm run dev

# Production build
npm run build
```
### 7. Start Development Server
```bash
# Method 1: Using Laravel's built-in server
php artisan serve

# Method 2: Using the dev script (recommended)
composer run dev
```
Visit http://localhost:8000 to access the application.

---

## 🏗️ Project Structure
INNOFORUM/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/              # Admin-specific controllers
│   │   │   ├── Auth/               # Authentication controllers
│   │   │   ├── AuthController.php  # Main auth controller
│   │   │   ├── QuestionController.php
│   │   │   ├── CommentController.php
│   │   │   └── ...
│   │   ├── Middleware/             # Custom middleware
│   │   │   ├── AdminMiddleware.php
│   │   │   ├── RoleMiddleware.php
│   │   │   └── ...
│   │   └── Requests/               # Form requests
│   ├── Models/                     # Eloquent models
│   │   ├── User.php
│   │   ├── Question.php
│   │   ├── Comment.php
│   │   ├── Notification.php
│   │   └── ...
│   ├── Mail/                       # Mail classes
│   │   ├── UserOtpMail.php
│   │   └── ...
│   └── Livewire/                   # Livewire components
├── database/
│   ├── migrations/                 # Database migrations
│   └── seeders/                   # Database seeders
├── resources/
│   ├── views/                     # Blade templates
│   │   ├── admin/                 # Admin views
│   │   ├── auth/                  # Authentication views
│   │   ├── questions/             # Question views
│   │   └── ...
│   ├── js/                        # JavaScript files
│   └── css/                       # CSS files
├── routes/
│   ├── web.php                    # Web routes
│   └── api.php                    # API routes
├── public/                        # Public assets
├── storage/                       # Storage directory
├── composer.json                  # PHP dependencies
├── package.json                   # Node.js dependencies
└── vite.config.js                # Vite configuration

---

## 🎮 Usage Guide
For Students & Lecturers
1. Registration Process:
    - NIM/NIDM Validation: Enter your student/lecturer ID
    - Complete Registration: Fill out the registration form
    - Email Verification: Enter the OTP code sent to your email
    - Profile Completion: Add additional profile information
    - Login: Access the forum with your credentials

2. Using the Forum:
    - Browse Discussions: View threads by category or hashtags
    - Create Threads: Start new discussions with rich content
    - Comment & Interact: Reply to threads, upload images, mention users
    - Notifications: Receive alerts for interactions and announcements

For Administrators
1. Access Admin Panel:
    - Special Validation: Use admin code 404039582 during NIM validation
    - OTP Verification: Enter OTP code from database
    - Admin Login: Use admin credentials to access dashboard

2. Admin Features:
    - User Management: Create, edit, delete, and manage user accounts
    - Content Moderation: Review reports, moderate discussions
    - System Administration: Manage categories, send announcements
    - Analytics: View platform statistics and user activity

---

## ⚙️ Configuration
Mail Configuration (Required for OTP)
Configure SMTP settings in .env:
```bash
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```
Database Options
SQLite (Default):
```bash
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database/database.sqlite
```
MySQL:
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=innoforum
DB_USERNAME=root
DB_PASSWORD=your-password
```
PostgreSQL:
```bash
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=innoforum
DB_USERNAME=postgres
DB_PASSWORD=your-password
```

---

## 🧪 Development
Code Style
This project follows PSR-12 coding standards.
```bash
# Check code style
composer check-style

# Fix code style
composer fix-style
```
Asset Compilation
```bash
# Development with hot reload
npm run dev

# Production build
npm run build

# Watch for changes
npm run watch
```

Testing
```bash
# Run all tests
composer test
# or
php artisan test

# Run specific test suite
vendor/bin/phpunit --testsuite=Feature
```

Common Artisan Commands
```bash
# Clear all caches
php artisan optimize:clear

# Create a new model with migration and controller
php artisan make:model ModelName -mc

# Run specific migrations
php artisan migrate --path=/database/migrations/specific_migration.php

# Create new seeder
php artisan make:seeder SeederName

# Create new controller
php artisan make:controller ControllerName

# Create new middleware
php artisan make:middleware MiddlewareName
```

---

## 🔧 Troubleshooting
Common Issues
1. Permission Issues:
```bash
# Fix storage and cache permissions
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
chown -R www-data:www-data storage/
chown -R www-data:www-data bootstrap/cache/
```

2. Database Connection Issues:
```bash
# For SQLite, ensure file exists and is writable
touch database/database.sqlite
chmod 664 database/database.sqlite

# Clear configuration cache
php artisan config:clear
php artisan cache:clear
```

3. Asset Compilation Issues:
```bash
# Clear Node modules and reinstall
rm -rf node_modules/
rm package-lock.json
npm install

# Clear Vite cache
rm -rf node_modules/.vite
npm run build
```
4. OTP/Email Issues:
    - Verify SMTP credentials in .env
    - Check if emails are going to spam folder
    - Test mail configuration: php artisan tinker then
    ```bash
    Mail::raw('Test', function($m) { $m->to('test@example.com')->subject('Test'); });
    ```

5. Session Issues:
```bash
# Clear sessions and cache
php artisan session:table
php artisan migrate
php artisan cache:clear
php artisan config:clear
```

---

## 🤝 Contributing
We welcome contributions! Please follow these guidelines:
1. Getting Started
    - Fork the repository
    - Create a feature branch: git checkout -b feature/amazing-feature
    - Make your changes following our coding standards
    - Write/update tests for new functionality
    - Commit your changes: git commit -m 'Add amazing feature'
    - Push to the branch: git push origin feature/amazing-feature
    - Open a Pull Request

2. Development Guidelines
    - Follow PSR-12 coding standards
    - Write meaningful commit messages
    - Update documentation for new features
    - Ensure all tests pass before submitting PR
    - Use descriptive variable and method names
    - Comment complex logic appropriately

3. Code Review Process
    - All submissions require review
    - Maintain backward compatibility when possible
    - Follow existing architectural patterns
    - Ensure responsive design for frontend changes

---

## 👥 Team
## Team

### Core Contributors

| Avatar | Name | Role | Responsibilities | Contact |
|--------|------|------|-----------------|---------|
| 👨‍💻 | **Ahmad Zidan Tamimy** | Team Leader & Backend Developer | • System architecture<br>• Backend development<br>• Database design<br>• Authentication system<br>• Role-based access control | ahmadzidantammimy@gmail.com |
| 👩‍💻 | **Agni Fatya Kholila** | Documentation & Frontend Developer | • Project documentation<br>• Frontend implementation<br>• UI/UX design<br>• Project reporting<br>• User interface components | agnifatyakholila@gmail.com |

### Project Statistics

| Metric | Value |
|--------|-------|
| **Lines of Code** | 15,000+ |
| **Development Time** | 6 months |
| **Technologies Used** | 8+ |
| **Features Implemented** | 20+ |

### Contribution Guidelines

We welcome contributions from the community! Here's how different types of contributors can help:

| Contributor Type | How to Help | Skills Needed |
|-----------------|-------------|---------------|
| **Developers** | Code features, fix bugs, improve performance | PHP, Laravel, JavaScript, CSS |
| **Designers** | UI/UX improvements, icons, layouts | Design tools, CSS, User experience |
| **Testers** | Report bugs, test new features | Attention to detail, various devices |
| **Documenters** | Improve docs, write tutorials | Technical writing, markdown |
| **Translators** | Add language support | Native language skills |

### Contact Information

| Type | Details |
|------|---------|
| **Primary Contact** | ahmadzidantammimy@gmail.com |
| **Secondary Contact** | agnifatyakholila@gmail.com |
| **GitHub Issues** | [Report bugs here](https://github.com/FrederiyPatria/INNOFORUM/issues) |
| **GitHub Discussions** | [Community discussions](https://github.com/FrederiyPatria/INNOFORUM/discussions) |
| **Response Time** | Usually within 24-48 hours |

---

## 📄 License
This project is licensed under the MIT License.
```bash
MIT License

Copyright (c) 2024 Ahmad Zidan Tamimy & Agni Fatya Kholila

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
```
You are free to:

✅ Use the software for any purpose
✅ Modify the source code
✅ Distribute copies
✅ Include in commercial projects

Conditions:

📋 Include the original license and copyright notice
📋 State changes made to the original code

---

## 📞 Support
For questions, issues, or support:

📧 Email: ahmadzidantammimy@gmail.com, agnifatyakholila@gmail.com
🐛 Bug Reports: GitHub Issues
💬 Discussions: GitHub Discussions

Before Asking for Help
1. Check the Troubleshooting section
2. Search existing Issues
3. Provide detailed information about your environment and the issue

---

## 🚀 Roadmap
Current Version Features
- ✅ Role-based authentication system
- ✅ Discussion threads with categories
- ✅ Comment system with image uploads
- ✅ Real-time notifications
- ✅ Admin dashboard and user management
- ✅ Email OTP verification
- ✅ Content moderation tools

Planned Features
- 🔄 Real-time chat functionality
- 🔄 Mobile-responsive improvements
- 🔄 Advanced search with filters
- 🔄 File attachment support
- 🔄 Integration with academic systems
- 🔄 API for third-party integrations
- 🔄 Enhanced analytics dashboard
- 🔄 Multi-language support

Future Considerations
- 📱 Mobile app development
- 🔗 Single Sign-On (SSO) integration
- 📊 Advanced reporting features
- 🎨 Theme customization
- 🔌 Plugin system

---

## 🙏 Acknowledgments
- Laravel Framework: For providing an excellent foundation for web development
- Tailwind CSS: For the utility-first CSS framework
- Alpine.js: For lightweight JavaScript interactions
- Livewire: For seamless PHP-JavaScript integration
- Vite: For fast and modern build tooling
- Open Source Community: For inspiration, tools, and continuous learning

---

## 🖼  Screenshots

### 🔹 Admin Pages
- **Dashboard Admin**  
  ![Dashboard Admin](Laporan%20proyek%20INNOFORUM/halaman%20admin/Tampilan%20dashboard%20admin.png)

- **Data User**  
  ![Data User](Laporan%20proyek%20INNOFORUM/halaman%20admin/Tampilan%20admin%20data%20user.png)

- **Data Kategori Forum**  
  ![Data Kategori Forum](Laporan%20proyek%20INNOFORUM/halaman%20admin/Tampilan%20admin%20daftar%20kategori%20forum.png)

- **Daftar Semua Komentar**  
  ![Semua Komentar](Laporan%20proyek%20INNOFORUM/halaman%20admin/Tampilan%20admin%20daftar%20semua%20komentar.png)

- **Data Thread**  
  ![Data Thread](Laporan%20proyek%20INNOFORUM/halaman%20admin/Tampilan%20admin%20data%20semat%20thread.png)

---

### 🔹 Forum Pages
- **Dashboard Forum**  
  ![Dashboard Forum Asli](Laporan%20proyek%20INNOFORUM/halaman%20proyek%20web%20forum/dashboard%20forum%20asli.png)

- **Halaman Buat Pertanyaan**  
  ![Buat Pertanyaan Asli](Laporan%20proyek%20INNOFORUM/halaman%20proyek%20web%20forum/halaman%20buat%20pertanyaan%20asli.png)

- **Contact Us**  
  ![Contact Us Asli](Laporan%20proyek%20INNOFORUM/halaman%20proyek%20web%20forum/halaman%20contact%20us%20asli.png)

- **Diskusi**  
  ![Diskusi Asli](Laporan%20proyek%20INNOFORUM/halaman%20proyek%20web%20forum/halaman%20diskusi%20asli.png)

---

### 🔹 User Profile Pages
- **Profil Dosen**  
  ![Profil Dosen Asli](Laporan%20proyek%20INNOFORUM/halaman%20proyek%20web%20forum/halaman%20profil%20dosen%20asli.png)

- **Profil Mahasiswa**  
  ![Profil Mahasiswa Asli](Laporan%20proyek%20INNOFORUM/halaman%20proyek%20web%20forum/halaman%20profil%20mahasiswa%20asli.png)
  
- **Edit Profil Dosen**  
  ![Edit Profil Dosen Asli](Laporan%20proyek%20INNOFORUM/halaman%20proyek%20web%20forum/halaman%20edit%20profil%20dosen%20asli.png)

- **Edit Profil Mahasiswa**  
  ![Edit Profil Mahasiswa Asli](Laporan%20proyek%20INNOFORUM/halaman%20proyek%20web%20forum/halaman%20edit%20profil%20mahasiswa%20asli.png)

- **Lengkapi Profil Dosen**  
  ![Lengkapi Profil Dosen Asli](Laporan%20proyek%20INNOFORUM/halaman%20proyek%20web%20forum/halaman%20lengkapi%20profil%20dosen%20asli.png)

- **Lengkapi Profil Mahasiswa**  
  ![Lengkapi Profil Mahasiswa Asli](Laporan%20proyek%20INNOFORUM/halaman%20proyek%20web%20forum/halaman%20lengkapi%20profil%20mahasiswa%20asli.png)

---

### 🔹 Authentication Pages
- **Login Admin**  
  ![Login Admin](Laporan%20proyek%20INNOFORUM/halaman%20proyek%20web%20forum/login%20admin%20asli.png)

- **Login Dosen**  
  ![Login Dosen](Laporan%20proyek%20INNOFORUM/halaman%20proyek%20web%20forum/login%20register%20dosen%201%20asli.png)

- **Register Dosen**  
  ![Login Dosen 2](Laporan%20proyek%20INNOFORUM/halaman%20proyek%20web%20forum/login%20register%20dosen%202%20asli.png)

- **Login Mahasiswa**  
  ![Login Mahasiswa](Laporan%20proyek%20INNOFORUM/halaman%20proyek%20web%20forum/login%20register%20mahasiswa%201%20asli.png)

- **Register Mahasiswa**  
  ![Login Mahasiswa 2](Laporan%20proyek%20INNOFORUM/halaman%20proyek%20web%20forum/login%20register%20mahasiswa%202%20asli.png)

---

### 🔹 Validation & OTP Pages
- **Validasi Awal**  
  ![Validasi Awal Asli](Laporan%20proyek%20INNOFORUM/halaman%20proyek%20web%20forum/halaman%20validasi%20awal%20asli.png)

- **Validasi OTP Admin**  
  ![Validasi OTP Admin Asli](Laporan%20proyek%20INNOFORUM/halaman%20proyek%20web%20forum/halaman%20validasi%20otp%20admin%20asli.png)

- **Validasi OTP User**  
  ![Validasi OTP User](Laporan%20proyek%20INNOFORUM/halaman%20proyek%20web%20forum/halaman%20validasi%20otp%20user%20asli.png)

---

## 📽 Demo & Roadmap Visual

Berikut adalah gambaran visual alur sistem & roadmap proyek **INNOFORUM**:

### 🔹 System Flow
![System Flow](Laporan%20proyek%20INNOFORUM/alur%20logik%20forum.png)

### 🔹 Roadmap Proyek
![Roadmap INNOFORUM](Laporan%20proyek%20INNOFORUM/Roadmap%20Visual%20Proyek%20Forum%20Diskusi%20Kampus%20(INNOFORUM).png)

### 🔹 Data Base
![Roadmap INNOFORUM](Laporan%20proyek%20INNOFORUM/Data%20Base%20Innoforum.png)

---

Built with ❤️ for Indonesian academic communities
