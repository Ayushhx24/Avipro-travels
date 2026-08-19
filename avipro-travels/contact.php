<?php 
include('admin/includes/header.php');

$contact_phone = $pdo->query("SELECT setting_value FROM site_settings WHERE setting_key = 'contact_phone'")->fetchColumn() ?: 'N/A';
$contact_email = $pdo->query("SELECT setting_value FROM site_settings WHERE setting_key = 'contact_email'")->fetchColumn() ?: 'N/A';
?>

    <h1>Contact Us</h1>
    <div class="contact-info">
        <p>📞 **Phone:** <?php echo htmlspecialchars($contact_phone); ?></p>
        <p>📧 **Email:** <?php echo htmlspecialchars($contact_email); ?></p>
        <div style="margin-top: 30px; border: 1px solid #ccc; padding: 20px; text-align: center;">
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3670.5356488718035!2d76.84874337509355!3d23.07747957913534!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x397ce9ceaaaaaaab%3A0xa224b6b82b421f83!2sVIT%20Bhopal%20University!5e0!3m2!1sen!2sin!4v1764929364263!5m2!1sen!2sin" 
        width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" 
        referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>

<?php 
include('admin/includes/footer.php'); 
?>