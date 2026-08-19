<?php
require_once('includes/check_login.php'); 
include('includes/admin_header.php'); 
?>

<main>
    <h1>Welcome to the Avipro Travels CMS, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    
    <p>Use the navigation menu above to manage the website content.</p>

    <h2>Quick Links:</h2>
    <ul>
        <li><a href="manage_packages.php">Manage Tour Packages (Add, Edit, Delete)</a></li>
        <li><a href="view_enquiries.php">View Booking/Enquiry Requests</a></li>
        <li><a href="site_settings.php">Update Site Content (About Us, Contact Info)</a></li>
    </ul>
    
    <div style="margin-top: 30px; padding: 15px; border: 1px solid #ccc;">
        <p>Your current session is active. <a href="logout.php">Click here to safely logout.</a></p>
    </div>
</main>

<?php include('includes/admin_footer.php'); ?>