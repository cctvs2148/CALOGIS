# Logistics College Management System - CAIIHM Logistics College

A PHP + MySQL logistics and supply chain management college website with a powerful admin CMS.

## Tech Stack
- PHP 8+
- MySQL
- Bootstrap 5
- JavaScript
- AJAX
- jQuery
- XAMPP Compatible
- Responsive Design
- SEO Friendly

## Installation Guide (XAMPP)

1. Copy the project folder into `C:\xampp\htdocs\CALOGI`.
2. Start Apache and MySQL from the XAMPP Control Panel.
3. Open `http://localhost/phpmyadmin`.
4. Create a new database or import the schema:
   - Click `Import`
   - Choose `database/schema.sql`
   - Run the import
5. Configure database connection if needed:
   - Edit `config/database.php`
   - Update `$host`, `$db`, `$user`, and `$pass`
6. Ensure the following folders are writable by PHP:
   - `uploads/courses`
   - `uploads/events`
   - `uploads/blogs`
   - `uploads/gallery`
7. Open the site in your browser:
   - Public site: `http://localhost/CALOGI/`
   - Admin panel: `http://localhost/CALOGI/admin/`

## Default Admin Login
- Email: `admin@example.com`
- Password: `Admin@123`

## Project Structure
```
logistics-college/
├── admin/
├── assets/
│   ├── css/
│   ├── js/
│   ├── images/
├── uploads/
│   ├── courses/
│   ├── events/
│   ├── blogs/
│   ├── gallery/
├── includes/
├── config/
├── database/
├── pages/
├── api/
└── index.php
```

## Features
- Admin authentication with hashed passwords and CSRF protection
- Home hero content editable from admin
- Courses, placements, events, blogs, gallery, testimonials modules
- Admissions form with status updates and CSV export
- Contact message management
- SEO metadata editor
- Responsive modern design with navy and orange accents

## Notes
- The blog editor uses CKEditor for rich content editing.
- Form submissions are secured with CSRF tokens.
- Use the `database/schema.sql` script to recreate the database schema and load sample data.
