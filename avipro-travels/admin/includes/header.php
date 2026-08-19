<?php
require_once('config/db.php'); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avipro Travels - Plan Your Perfect Getaway</title>
    <link rel="stylesheet" href="assets/css/style.css"> 
    <style>
        body { font-family: sans-serif; margin: 0; padding: 0; }
        header { background-color: #333; color: white; padding: 10px 20px; }
        nav ul { list-style: none; padding: 0; margin: 0; display: flex; }
        nav ul li { margin-right: 20px; }
        nav ul li a { color: white; text-decoration: none; }
        main { padding: 20px; min-height: 600px; }
        .hero-banner { background: #f0f0f0; padding: 50px; text-align: center; margin-bottom: 30px; }
        .package-grid, .package-listing { display: flex; flex-wrap: wrap; gap: 20px; }
        .package-card { border: 1px solid #ccc; padding: 15px; width: calc(33% - 20px); text-align: center; }
        .package-list-item { border: 1px solid #ccc; padding: 15px; width: 100%; display: flex; gap: 20px; margin-bottom: 10px; }
        .package-list-item img { width: 150px; height: 100px; object-fit: cover; }
        .price { font-weight: bold; color: green; }
        .btn-primary, .btn-details, .btn-book-now { display: inline-block; padding: 8px 15px; background-color: #007bff; color: white; text-decoration: none; border-radius: 4px; }
    </style>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="packages.php">Tour Packages</a></li>
                <li><a href="contact.php">Contact Us</a></li>
                <li><a href="booking_enquiry.php" style="color: yellow;">Book/Enquire</a></li>
                <li><a href="admin/login.php">Admin CMS</a></li>
            </ul>
        </nav>
    </header>
    <main>
