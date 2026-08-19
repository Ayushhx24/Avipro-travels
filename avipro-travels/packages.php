<?php 
require_once('config/db.php');
$all_packages = $pdo->query("SELECT id, title, destination, duration, price FROM packages ORDER BY created_at DESC")->fetchAll();
?>

<?php include('admin/includes/header.php'); ?>

    <h1>All Tour Packages</h1>
    
    <div class="package-listing">
        <?php if (!empty($all_packages)): ?>
            <?php foreach ($all_packages as $pkg): 
                $img_path_stmt = $pdo->prepare("SELECT image_path FROM package_images WHERE package_id = ? AND is_primary = 1 LIMIT 1");
                $img_path_stmt->execute([$pkg['id']]);
                $primary_image = $img_path_stmt->fetchColumn() ?: 'assets/images/placeholder.jpg';
            ?>
            <div class="package-list-item">
                <img src="<?php echo htmlspecialchars($primary_image); ?>" alt="<?php echo htmlspecialchars($pkg['title']); ?>">
                <div class="details">
                    <h3><?php echo htmlspecialchars($pkg['title']); ?></h3>
                    <p>Destination: **<?php echo htmlspecialchars($pkg['destination']); ?>**</p>
                    <p>Duration: <?php echo htmlspecialchars($pkg['duration']); ?></p>
                    <p class="price">Price: $<?php echo htmlspecialchars(number_format($pkg['price'], 0)); ?></p>
                    <a href="package_details.php?id=<?php echo $pkg['id']; ?>" class="btn btn-readmore">Explore Package</a>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>We are currently updating our package list. Please check back soon!</p>
        <?php endif; ?>
    </div>

<?php include('admin/includes/footer.php'); ?>