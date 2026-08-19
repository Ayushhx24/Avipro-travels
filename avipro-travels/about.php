<?php 
require_once('config/db.php');
$about_text = $pdo->query("SELECT setting_value FROM site_settings WHERE setting_key = 'about_us_content'")->fetchColumn() ?: 'Welcome to Avipro Travels! Content pending.';
?>

<?php include('admin/includes/header.php'); ?>
    <h1>About Avipro Travels</h1>
    <div class="about-content">
        <p><?php echo nl2br(htmlspecialchars($about_text)); ?></p>
    </div>
<?php include('admin/includes/footer.php'); ?>