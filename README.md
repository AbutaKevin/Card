# State Department Job Card Management System

This project is a PHP-based job card and ID card management system built for the State Department for Lands and Physical Planning.

## Setup

1. Copy the project into your Apache `htdocs` directory.
2. Ensure PHP 8+ and MySQL are installed and running.
3. Create the database and tables using the SQL script:
   - Import `database/schema.sql` into MySQL.
4. Adjust database credentials in `app/config/config.php` if needed.
5. Access the system in your browser at `http://localhost/Card/public`.

## Default user

- Username: `admin`
- Password: `Admin@1234`

## Features

- Secure authentication with role support
- Staff management with photo/signature upload
- Job card generation and QR verification
- Dashboard with summary cards and recent activity
- Search and filtering for staff records
- Audit logging for user actions

## Notes

- The generated job card preview uses browser print for PDF export.
- File uploads are stored under `storage/uploads/`.
- QR codes are saved to `storage/qrcodes/`.
