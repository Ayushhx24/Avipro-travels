<?php
require_once('check_login.php'); 

require_once('../config/db.php'); 

$admin_name = $_SESSION['full_name'] ?? $_SESSION['username'] ?? 'Admin';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMS Dashboard - Avipro Travels</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f8f9fa; margin: 0; padding: 0; }
        .admin-header { background-color: #007bff; color: white; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; }
        .admin-header h2 { margin: 0; font-size: 1.5em; }
        .nav-links a { color: white; text-decoration: none; margin-left: 25px; padding: 5px 0; border-bottom: 2px solid transparent; }
        .nav-links a:hover { border-bottom: 2px solid #ffc107; }
        main { padding: 20px; }
        .welcome { color: #555; }
        table { border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
    </style>
</head>
<body>
    <div class="admin-header">
        <h2>Avipro CMS</h2>
        <nav class="nav-links">
            <a href="dashboard.php">Dashboard</a>
            <a href="manage_packages.php">Packages</a>
            <a href="view_enquiries.php">Enquiries</a>
            <a href="site_settings.php">Settings</a>
            <span class="welcome">Welcome, <?php echo htmlspecialchars($admin_name); ?>!</span>
            <a href="logout.php" style="color: #ffc107;">Logout</a>
        </nav>
    </div>
    <main>

