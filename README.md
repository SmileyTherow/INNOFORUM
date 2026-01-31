<h1 align="center">🚀 INNOFORUM</h1>

![Demo](Laporan%20proyek%20INNOFORUM/2025-08-2611-03-43-ezgif.com-video-to-gif-converter.gif)

<h2 align="center">Ignite Innovation, Connect Minds, Shape the Future</h2>

[![Last Commit](https://img.shields.io/github/last-commit/FrederiyPatria/INNOFORUM)](https://github.com/FrederiyPatria/INNOFORUM/commits/main)
![Languages](https://img.shields.io/github/languages/count/FrederiyPatria/INNOFORUM)
![Repo Size](https://img.shields.io/github/repo-size/FrederiyPatria/INNOFORUM)

A comprehensive academic discussion forum built with Laravel, designed specifically for Indonesian educational institutions to foster community engagement between students and lecturers.

Built with modern tools & technologies:
<p align="left">
  <img src="https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" />
  <img src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white" />
  <img src="https://img.shields.io/badge/Composer-885630?style=for-the-badge&logo=composer&logoColor=white" />
  <img src="https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black" />
  <img src="https://img.shields.io/badge/Vite-646CFF?style=for-the-badge&logo=vite&logoColor=white" />
  <img src="https://img.shields.io/badge/TailwindCSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" />
  <img src="https://img.shields.io/badge/Axios-5A29E4?style=for-the-badge&logo=axios&logoColor=white" />
  <img src="https://img.shields.io/badge/Excalidraw-000000?style=for-the-badge&logo=excalidraw&logoColor=white" />
</p>

---

## 📖 Table of Contents
- [Overview](#-overview)
- [Academic Context](#-academic-context)
    - [Learning Objectives Achieved](#learning-objectives-achieved)
    - [Technical Skills Demonstrated](#technical-skills-demonstrated)
    - [Development Timeline](#-development-timeline)
- [Course Requirements Fulfilled](#-course-requirements-fulfilled)
    - [Mandatory Requirements](#-mandatory-requirements)
    - [Additional Features](#-additional-features)
- [Features](#-features)
- [Prerequisites](#-prerequisites)
- [Installation](#-installation)
    - [Clone Repository](#1-clone-repository)
    - [Install Dependencies](#2-install-dependencies)
    - [Environment Setup](#3-environment-setup)
    - [EnviConfigure Environment](#4-enviconfigure-environment)
    - [Database Migration](#5-database-migration)
    - [Build Assets](#6-build-assets)
    - [Start Development Server](#7-start-development-server)
- [Project Structure](#️-project-structure)
- [System Design](#-system-design)
    - [Database Schema (ERD)](#database-schema-erd)
    - [Use Case Diagram](#use-case-diagram)
- [Usage Guide](#-usage-guide)
    - [For Students & Lecturers](#for-students--lecturers)
        - [Registration Process](#1-registration-process)
        - [Using the Forum](#2-using-the-forum)
    - [For Administrators](#for-administrators)
        - [Access Admin Panel](#1-access-admin-panel)
        - [Admin Features](#2-admin-features)
- [Configuration](#️-configuration)
    - [Mail Configuration](#mail-configuration-required-for-otp)
    - [Database Options SQLite](#database-options)
    - [MySQL](#mysql)
    - [PostgreSQL](#postgresql)
- [Development](#-development)
- [Troubleshooting](#-troubleshooting)
    - [Permission Issues](#1-permission-issues)
    - [Database Connection Issues](#2-database-connection-issues)
    - [Asset Compilation Issues](#3-asset-compilation-issues)
    - [OTP/Email Issues](#4-otpemail-issues)
    - [Session Issues](#5-session-issues)
- [Contributing](#-contributing)
    - [Getting Started](#1-getting-started)
    - [Development Guidelines](#2-development-guidelines)
    - [Code Review Process](#3-code-review-process)
- [Team](#-team)
    - [Core Contributors](#core-contributors)
    - [Project Statistics](#project-statistics)
    - [Contribution Guidelines](#contribution-guidelines)
    - [Contact Information](#contact-information)
- [License](#-license)
- [Support](#-support)
- [Roadmap](#-roadmap)
    - [Current Version Features](#current-version-features)
    - [Planned Features](#planned-features)
    - [Future Considerations](#future-considerations)
- [Acknowledgments](#-acknowledgments)
- [Security Features](#-security-features)
- [Screenshots](#--screenshots)
    - [Admin Pages](#-admin-pages)
    - [Forum Pages](#-forum-pages)
    - [User Profile Pages](#-user-profile-pages)
    - [Authentication Pages](#-authentication-pages)
    - [Validation & OTP Pages](#-validation--otp-pages)
- [Demo & Roadmap Visual](#-demo--roadmap-visual)
    - [Live Demo](#-live-demo)
    - [System Flow](#-system-flow)
    - [Roadmap Proyek](#-roadmap-proyek)
    - [Data Base](#-data-base)
- [Academic Project Details](#-academic-project-details)

---

## 🔎 Overview
**INNOFORUM** is a feature-rich discussion platform that facilitates academic discussions and knowledge sharing within campus communities. The system supports role-based access control, real-time notifications, content moderation, and comprehensive user management.

---

## 📚 Academic Context

This project was developed as a semester-long assignment for **PPW (Perancangan dan Pemrograman Web)** course, demonstrating comprehensive web development skills using modern technologies and best practices.

### Learning Objectives Achieved
- **Full-Stack Development**: Complete Laravel application with frontend integration
- **Database Design**: Comprehensive ERD implementation with proper relationships
- **Authentication & Authorization**: Role-based access control system
- **Real-time Features**: Notifications and dynamic user interactions
- **Code Quality**: PSR-12 standards and testing implementation
- **Deployment**: Production-ready application structure

### Technical Skills Demonstrated
- **Backend**: PHP 8.2+, Laravel 12, Eloquent ORM, Middleware
- **Frontend**: Tailwind CSS, Alpine.js, Vite, Responsive Design
- **Database**: SQLite/MySQL, Migrations, Seeders, Relationships
- **Security**: CSRF Protection, Input Validation, OTP Verification
- **Architecture**: MVC Pattern, Service Layer, Repository Pattern

### 📅 Development Timeline
- **Week 1-2**: Project planning, requirements analysis, ERD design
- **Week 3-4**: Laravel setup, authentication system, database design
- **Week 5-6**: Core forum functionality, user management
- **Week 7-8**: Admin panel, content moderation, notifications
- **Week 9-10**: Frontend enhancement, responsive design
- **Week 11-12**: Testing, debugging, documentation
- **Week 13-14**: Final optimization, deployment preparation

---

## 📋 Course Requirements Fulfilled

### ✅ Mandatory Requirements
- [x] **MVC Architecture**: Proper separation of concerns
- [x] **Database Integration**: Complex relational database design
- [x] **User Authentication**: Complete auth system with roles
- [x] **CRUD Operations**: Full create, read, update, delete functionality
- [x] **Form Validation**: Client and server-side validation
- [x] **File Upload**: Image handling for profiles and comments
- [x] **Session Management**: Secure session handling
- [x] **Responsive Design**: Mobile-friendly interface

### ✅ Additional Features
- [x] **Real-time Notifications**: Dynamic user alerts
- [x] **Email Integration**: OTP verification system
- [x] **Advanced Search**: Filter and search functionality
- [x] **Admin Dashboard**: Complete management interface
- [x] **Content Moderation**: Report and moderation system
- [x] **API-ready Structure**: RESTful design principles
- [x] **Testing Suite**: Unit and feature tests
- [x] **Modern Frontend**: Vite, Tailwind CSS, Alpine.js

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

## 🗂️ Project Structure
```text
INNOFORUM/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/                          # Admin-specific controllers
│   │   │   │   ├── AdminAnnouncementController.php
│   │   │   │   ├── AdminCategoryController.php
│   │   │   │   ├── AdminCommentController.php
│   │   │   │   ├── AdminUserController.php
│   │   │   │   ├── AdminThreadController.php
│   │   │   │   ├── AdminStatsController.php
│   │   │   │   └── DashboardController.php
│   │   │   ├── Auth/                           # Authentication controllers
│   │   │   │   ├── AdminLoginController.php
│   │   │   │   ├── AuthenticatedSessionController.php
│   │   │   │   ├── OtpController.php
│   │   │   │   ├── PasswordController.php
│   │   │   │   └── VerifyEmailController.php
│   │   │   ├── AuthController.php              # Main auth & registration logic
│   │   │   ├── QuestionController.php          # Forum questions/threads
│   │   │   ├── CommentController.php           # Comments with image upload
│   │   │   ├── NotificationController.php      # User notifications
│   │   │   ├── UserController.php              # Profile management
│   │   │   ├── ReportController.php            # Content reporting
│   │   │   └── ContactController.php           # Contact form
│   │   ├── Middleware/
│   │   │   ├── AdminMiddleware.php             # Admin access control
│   │   │   ├── RoleMiddleware.php              # Role-based permissions
│   │   │   ├── ForceNimSession.php             # NIM validation session
│   │   │   └── MahasiswaDosenMiddleware.php    # Student/lecturer access
│   │   └── Requests/                           # Form validation
│   │       ├── Auth/LoginRequest.php
│   │       └── ProfileUpdateRequest.php
│   ├── Models/
│   │   ├── User.php                            # User with roles & OTP
│   │   ├── Question.php                        # Forum questions/threads
│   │   ├── Comment.php                         # Comments with images
│   │   ├── Notification.php                    # Real-time notifications
│   │   ├── Category.php                        # Question categories
│   │   ├── Hashtag.php                         # Thread hashtags
│   │   ├── Report.php                          # Content reports
│   │   ├── Announcement.php                    # Admin announcements
│   │   └── UserProfile.php                     # Extended user profiles
│   ├── Mail/                                   # Email classes
│   │   ├── UserOtpMail.php                     # OTP verification emails
│   │   ├── TestEmail.php                       # Email testing
│   │   └── PasswordConfirmationMail.php        # Password confirmations
│   └── Livewire/                               # Dynamic components
│       └── Admin/UserTable.php                 # Admin user management
├── database/
│   ├── migrations/                             # 25+ migration files
│   │   ├── create_users_table.php
│   │   ├── create_questions_table.php
│   │   ├── create_comments_table.php
│   │   ├── create_notifications_table.php
│   │   ├── create_categories_table.php
│   │   ├── create_hashtags_table.php
│   │   └── ...
│   ├── seeders/                                # Database seeding
│   │   ├── UserSeeder.php
│   │   ├── DataNimSeeder.php
│   │   └── DatabaseSeeder.php
│   └── factories/
│       └── UserFactory.php                     # Test data generation
├── resources/
│   ├── views/
│   │   ├── admin/                              # Admin dashboard views
│   │   │   ├── users/                          # User management
│   │   │   ├── categories/                     # Category management
│   │   │   ├── comments/                       # Comment moderation
│   │   │   ├── threads/                        # Thread management
│   │   │   └── dashboard.blade.php
│   │   ├── auth/                               # Authentication forms
│   │   │   ├── login_admin.blade.php
│   │   │   ├── login_register_mahasiswa.blade.php
│   │   │   ├── login_register_dosen.blade.php
│   │   │   ├── nim_or_nigm.blade.php
│   │   │   ├── user_otp.blade.php
│   │   │   └── otp_admin.blade.php
│   │   ├── questions/                          # Forum views
│   │   │   ├── create.blade.php
│   │   │   ├── show.blade.php
│   │   │   └── index.blade.php
│   │   ├── profile/                            # User profiles
│   │   ├── components/                         # Reusable components
│   │   ├── layouts/                            # Base layouts
│   │   └── dashboard.blade.php                 # Main dashboard
│   ├── js/
│   │   ├── app.js                              # Alpine.js initialization
│   │   ├── bootstrap.js                        # Axios configuration
│   │   └── role-handler.js                     # Dynamic form handling
│   └── css/
│       └── app.css                             # Tailwind CSS main file
├── routes/
│   ├── web.php                                 # All web routes
│   ├── auth.php                                # Authentication routes
│   └── console.php                             # Artisan commands
├── public/
│   ├── css/                                    # Compiled stylesheets
│   ├── js/                                     # Compiled JavaScript
│   ├── storage/                                # File uploads (symlinked)
│   └── admin/                                  # Admin template assets
├── storage/
│   ├── app/public/                             # File uploads
│   │   ├── photo/                              # User profile photos
│   │   ├── comment_images/                     # Comment images
│   │   └── question_images/                    # Question attachments
│   └── logs/                                   # Application logs
├── tests/
│   ├── Feature/                                # Feature tests
│   │   └── Auth/                               # Authentication tests
│   └── Unit/                                   # Unit tests
├── composer.json                               # PHP dependencies
├── package.json                                # Node.js dependencies
├── vite.config.js                              # Vite build configuration
└── database.sqlite                             # SQLite database file
```

---


## 📊 System Design
### Database Schema (ERD)
The database design follows a comprehensive relational model supporting all forum features:

![Database ERD](Laporan%20proyek%20INNOFORUM/Entity%20Relationship%20Diagram.png)

**Key Relationships:**
- **Users** → **Questions** (1:N) - Users can create multiple questions
- **Users** → **Comments** (1:N) - Users can post multiple comments  
- **Questions** → **Comments** (1:N) - Questions can have multiple comments
- **Users** → **Notifications** (1:N) - Users receive multiple notifications
- **Questions** ↔ **Hashtags** (N:M) - Questions can have multiple hashtags
- **Categories** → **Questions** (1:N) - Categories contain multiple questions

### Use Case Diagram
System functionality is organized around three main user roles:

![Use Case Diagram](Laporan%20proyek%20INNOFORUM/Rancangan%20Use%20Case%20Diagram.png)

**Actor Roles:**
- **Admin**: Complete system management, user moderation, content oversight
- **Mahasiswa (Student)**: Forum participation, profile management, notifications
- **Dosen (Lecturer)**: Enhanced forum access, student interaction, content creation

---

## 🎮 Usage Guide
### For Students & Lecturers
#### 1. Registration Process:
    - NIM/NIDM Validation: Enter your student/lecturer ID
    - Complete Registration: Fill out the registration form
    - Email Verification: Enter the OTP code sent to your email
    - Profile Completion: Add additional profile information
    - Login: Access the forum with your credentials

#### 2. Using the Forum:
    - Browse Discussions: View threads by category or hashtags
    - Create Threads: Start new discussions with rich content
    - Comment & Interact: Reply to threads, upload images, mention users
    - Notifications: Receive alerts for interactions and announcements

### For Administrators
#### 1. Access Admin Panel:
    - Special Validation: Use admin code (404039582) during NIM validation, otp (2531) and password (admin12345)
    - OTP Verification: Enter OTP code from database
    - Admin Login: Use admin credentials to access dashboard

#### 2. Admin Features:
    - User Management: Create, edit, delete, and manage user accounts
    - Content Moderation: Review reports, moderate discussions
    - System Administration: Manage categories, send announcements
    - Analytics: View platform statistics and user activity

---

## ⚙️ Configuration
### Mail Configuration (Required for OTP)
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
### Database Options
SQLite (Default):
```bash
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database/database.sqlite
```
### MySQL:
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=innoforum
DB_USERNAME=root
DB_PASSWORD=your-password
```
### PostgreSQL:
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
### 1. Permission Issues
```bash
# Fix storage and cache permissions
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
chown -R www-data:www-data storage/
chown -R www-data:www-data bootstrap/cache/
```

### 2. Database Connection Issues
```bash
# For SQLite, ensure file exists and is writable
touch database/database.sqlite
chmod 664 database/database.sqlite

# Clear configuration cache
php artisan config:clear
php artisan cache:clear
```

### 3. Asset Compilation Issues
```bash
# Clear Node modules and reinstall
rm -rf node_modules/
rm package-lock.json
npm install

# Clear Vite cache
rm -rf node_modules/.vite
npm run build
```
### 4. OTP/Email Issues
    - Verify SMTP credentials in .env
    - Check if emails are going to spam folder
    - Test mail configuration: php artisan tinker then
    ```bash
    Mail::raw('Test', function($m) { $m->to('test@example.com')->subject('Test'); });
    ```

### 5. Session Issues
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
### 1. Getting Started
    - Fork the repository
    - Create a feature branch: git checkout -b feature/amazing-feature
    - Make your changes following our coding standards
    - Write/update tests for new functionality
    - Commit your changes: git commit -m 'Add amazing feature'
    - Push to the branch: git push origin feature/amazing-feature
    - Open a Pull Request

### 2. Development Guidelines
    - Follow PSR-12 coding standards
    - Write meaningful commit messages
    - Update documentation for new features
    - Ensure all tests pass before submitting PR
    - Use descriptive variable and method names
    - Comment complex logic appropriately

### 3. Code Review Process
    - All submissions require review
    - Maintain backward compatibility when possible
    - Follow existing architectural patterns
    - Ensure responsive design for frontend changes

---

## 👥 Team

### Core Contributors

| Foto | Name | Role | Responsibilities | Contact |
|--------|------|------|-----------------|---------|
| ![Data Thread](Laporan%20proyek%20INNOFORUM/Ahmad%20Zidan%20Tamimy.jpg) | **Ahmad Zidan Tamimy** | Team Leader & Backend Developer | • System architecture<br>• Backend development<br>• Database design<br>• Authentication system<br>• Role-based access control | ahmadzidantammimy@gmail.com |
| ![Data Thread](Laporan%20proyek%20INNOFORUM/Agni%20Fatya%20Kholila.jpg) | **Agni Fatya Kholila** | Documentation & Frontend Developer | • Project documentation<br>• Frontend implementation<br>• UI/UX design<br>• Project reporting<br>• User interface components | agnifatyakholila@gmail.com |

### Project Statistics

| Metric | Value |
|--------|-------|
| **Lines of Code** | 15,000+ |
| **Development Time** | 4 months |
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
- ✅ Use the software for any purpose
- ✅ Modify the source code
- ✅ Distribute copies
- ✅ Include in commercial projects

Conditions:
- 📋 Include the original license and copyright notice
- 📋 State changes made to the original code

---

## 📞 Support
For questions, issues, or support:
- 📧 Email: ahmadzidantammimy@gmail.com, agnifatyakholila@gmail.com
- 🐛 Bug Reports: GitHub Issues
- 💬 Discussions: GitHub Discussions

Before Asking for Help
1. Check the Troubleshooting section
2. Search existing Issues
3. Provide detailed information about your environment and the issue

---

## 🚀 Roadmap
### Current Version Features
- ✅ Role-based authentication system
- ✅ Discussion threads with categories
- ✅ Comment system with image uploads
- ✅ Real-time notifications
- ✅ Admin dashboard and user management
- ✅ Email OTP verification
- ✅ Content moderation tools

### Planned Features
- 🔄 Real-time chat functionality
- 🔄 Mobile-responsive improvements
- 🔄 Advanced search with filters
- 🔄 File attachment support
- 🔄 Integration with academic systems
- 🔄 API for third-party integrations
- 🔄 Enhanced analytics dashboard
- 🔄 Multi-language support

### Future Considerations
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

## 🔒 Security Features

- ✅ **CSRF Protection**: All forms protected
- ✅ **XSS Prevention**: Input sanitization
- ✅ **SQL Injection**: Eloquent ORM protection
- ✅ **Authentication**: Secure password hashing
- ✅ **Email Verification**: OTP-based verification
- ✅ **Role-based Access**: Granular permissions
- ✅ **File Upload Security**: Type and size validation

---

## 🖼  Screenshots

### 🔹 Admin Pages
- **Dashboard Admin**  
  ![Dashboard Admin](<Laporan proyek INNOFORUM/halaman admin/(3) Halaman Dashboard admin.png>)

- **Data User**  
  ![Data User](<Laporan proyek INNOFORUM/halaman admin/(10) halaman manajemen pengguna.png>)

- **Data Kategori Forum**  
  ![Data Kategori Forum](<Laporan proyek INNOFORUM/halaman admin/(28) Halaman manajemen kategori.png>)

- **Daftar Semua Komentar**  
  ![Semua Komentar](<Laporan proyek INNOFORUM/halaman admin/(22) Halaman manajemen komentar.png>)

- **Data Thread/Pertanyaan**  
  ![Data Thread](<Laporan proyek INNOFORUM/halaman admin/(14) Halaman manajemen pertanyaan.png>)

---

### 🔹 Forum Pages
- **Dashboard Forum**  
  ![Dashboard Forum](<Laporan proyek INNOFORUM/halaman user/(18) Halaman Utama forum 1.png>)

- **Halaman Buat Pertanyaan**  
  ![Buat Pertanyaan](<Laporan proyek INNOFORUM/halaman user/(20) Halaman Buat pertanyaan.png>)

- **Contact Us**  
  ![Contact Us Asli](<Laporan proyek INNOFORUM/halaman user/(21) Halaman contac us.png>)

- **Diskusi**  
  ![Diskusi Asli](<Laporan proyek INNOFORUM/halaman user/(47) Halaman komentar.png>)

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

Berikut adalah  Live Demo, gambaran visual alur sistem, roadmap proyek & Data Base **INNOFORUM**:

### 🔹 Live Demo
Demo Video: [Live demo](Laporan%20proyek%20INNOFORUM//Demo.mp4)

### 🔹 System Flow
![System Flow](Laporan%20proyek%20INNOFORUM/alur%20logik%20forum.png)

### 🔹 Roadmap Proyek
![Roadmap INNOFORUM](Laporan%20proyek%20INNOFORUM/Roadmap%20Visual%20Proyek%20Forum%20Diskusi%20Kampus%20(INNOFORUM).png)

### 🔹 Data Base
![Roadmap INNOFORUM](Laporan%20proyek%20INNOFORUM/Data%20Base%20Innoforum.png)

---

## 📚 Academic Project Details

**Course Information:**
- **Subject**: PPW (Perancangan dan Pemrograman Web)
- **Duration**: 1 Semester (15 weeks) 
- **Academic Year**: 2025
- **Institution**: STTI NIIT I TECH
- **Faculty**: Tehnik Informatika
- **Supervising Lecturer**: Anjeng Puspita Ningrum, S.Kom

**Learning Outcomes Demonstrated:**
- Advanced Laravel framework implementation
- Database design and relationship management
- Authentication and authorization systems
- Modern frontend development practices
- Project management and documentation skills

**Project Scope:**
This project was developed to fulfill the final assignment requirements for Web Programming course, demonstrating comprehensive full-stack development skills.

**Technical Achievement:**
Successfully implemented a complete forum system using Laravel framework, exceeding course requirements with advanced features including real-time notifications, OTP verification, and comprehensive admin dashboard.

---

*Built with ❤️ for Indonesian academic communities as a PPW course final project*
