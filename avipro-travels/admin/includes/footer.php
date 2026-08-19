<?php 
$footer_phone = $pdo->query("SELECT setting_value FROM site_settings WHERE setting_key = 'contact_phone'")->fetchColumn() ?: 'N/A';
$footer_email = $pdo->query("SELECT setting_value FROM site_settings WHERE setting_key = 'contact_email'")->fetchColumn() ?: 'N/A';
?>
    </main>
    <footer>
        <hr>
        <div style="text-align: center; padding: 20px; background-color: #f4f4f4;">
            &copy; <?php echo date('Y'); ?> Avipro Travels. All rights reserved. | 
            Contact: <?php echo htmlspecialchars($footer_phone); ?> | 
            Email: <?php echo htmlspecialchars($footer_email); ?>
        </div>
    </footer>
    </body>
</html>