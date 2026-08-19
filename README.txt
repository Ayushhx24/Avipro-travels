Please follow these steps to deploy and run the project successfully:

A. Environment Requirements-
Web Server: XAMPP, WAMP, or equivalent (Apache).

Database: MySQL.

PHP Version: PHP 7.4 or later (PDO extension must be enabled).

B. Database Setup (Crucial Step)-
Start Services: Ensure Apache and MySQL are running in XAMPP control panel.

Access phpMyAdmin: Open your local phpMyAdmin interface(or you can access the database through MySQL-workbench/cmd).

Create Database: Create a new, empty database named avipro_travels. (This name is configured in config/db.php).

Import Data: Select the avipro_travels.sql file provided in the submission package. Use the Import tab to load all tables and initial sample data (packages, settings, and admin users).

C. Code Deployment-
Extract: Place the entire avipro-travels folder into your web server's root directory (C:\xampp\htdocs\ or equivalent).

Configuration Check: Verify the database connection file uses standard local credentials:
File: avipro-travels/config/db.php
Settings: Ensure DB_USERNAME and DB_PASSWORD match your local environment (e.g., root and '' for XAMPP defaults).