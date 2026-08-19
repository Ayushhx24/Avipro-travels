<?php
require_once('includes/check_login.php'); 
require_once('../config/db.php'); 

$status_message = '';

// Helper function to fetch a specific setting value
function get_setting($pdo, $key) {
    $sql = "SELECT setting_value FROM site_settings WHERE setting_key = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$key]);
    return $stmt->fetchColumn() ?: '';
}

// --- Handle POST Submission (Update) ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $about_us_content = trim($_POST['about_us_content'] ?? '');
    $contact_phone = trim($_POST['contact_phone'] ?? '');
    $contact_email = trim($_POST['contact_email'] ?? '');
    $banner_title = trim($_POST['banner_title'] ?? '');
    
    // Key-value pairs to update
    $updates = [
        'about_us_content' => $about_us_content,
        'contact_phone' => $contact_phone,
        'contact_email' => $contact_email,
        'banner_title' => $banner_title,
    ];

    try {
        $pdo->beginTransaction();
        
        // Use INSERT OR UPDATE (UPSERT) logic for each setting
        $sql = "INSERT INTO site_settings (setting_key, setting_value) VALUES (?, ?) 
                ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)";
        $stmt = $pdo->prepare($sql);
        
        foreach ($updates as $key => $value) {
            $stmt->execute([$key, $value]);
        }
        
        $pdo->commit();
        $status_message = "Site content and settings updated successfully!";
        header("Location: site_settings.php?status_message=" . urlencode($status_message));
        exit;
        
    } catch (PDOException $e) {
        $pdo->rollBack();
        $status_message = "Error updating settings: " . $e->getMessage();
    }
}

// --- Fetch current settings to pre-fill the form ---
$about_us_content = get_setting($pdo, 'about_us_content');
$contact_phone = get_setting($pdo, 'contact_phone');
$contact_email = get_setting($pdo, 'contact_email');
$banner_title = get_setting($pdo, 'banner_title');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Update Site Content</title>
</head>
<body>
    <?php include('includes/admin_header.php'); ?>
    
    <h1>Update Site Content & Settings</h1>
    
    <?php if (!empty($_GET['status_message'])) echo '<p style="color:green;">' . htmlspecialchars($_GET['status_message']) . '</p>'; ?>
    <?php if (!empty($status_message) && !isset($_GET['status_message'])) echo '<p style="color:red;">' . htmlspecialchars($status_message) . '</p>'; ?>

    <form action="site_settings.php" method="post">
        
        <h2>About Us Content</h2>
        <div>
            <label for="about_us_content">Full About Us Page Text:</label>
            <textarea name="about_us_content" id="about_us_content" rows="10" cols="80"><?php echo htmlspecialchars($about_us_content); ?></textarea>
        </div>
        
        <hr>
        <h2>Contact Information</h2>
        <div>
            <label for="contact_phone">Phone Number:</label>
            <input type="text" name="contact_phone" id="contact_phone" value="<?php echo htmlspecialchars($contact_phone); ?>">
        </div>
        <div>
            <label for="contact_email">Email Address:</label>
            <input type="email" name="contact_email" id="contact_email" value="<?php echo htmlspecialchars($contact_email); ?>">
        </div>
        
        <hr>
        <h2>Homepage Banner/Title</h2>
        <div>
            <label for="banner_title">Homepage Main Title:</label>
            <input type="text" name="banner_title" id="banner_title" value="<?php echo htmlspecialchars($banner_title); ?>">
        </div>

        <div style="margin-top: 20px;">
            <input type="submit" value="Save All Content Changes">
        </div>
    </form>
    
    <?php include('includes/admin_footer.php'); ?>
</body>
</html>