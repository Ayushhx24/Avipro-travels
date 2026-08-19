<?php 
require_once('config/db.php');

$package_id = $_GET['id'] ?? null;
$package = null;
$images = [];

if ($package_id) {
    $sql_pkg = "SELECT * FROM packages WHERE id = ?";
    $stmt_pkg = $pdo->prepare($sql_pkg);
    $stmt_pkg->execute([$package_id]);
    $package = $stmt_pkg->fetch();

    if ($package) {
        $sql_img = "SELECT image_path FROM package_images WHERE package_id = ? ORDER BY is_primary DESC";
        $stmt_img = $pdo->prepare($sql_img);
        $stmt_img->execute([$package_id]);
        $images = $stmt_img->fetchAll(PDO::FETCH_COLUMN);
    }
}

if (!$package) {
    header("HTTP/1.0 404 Not Found");
    echo "<h1>404 Package Not Found</h1><p>The requested package does not exist.</p>";
    exit;
}
?>

<?php include('admin/includes/header.php'); ?>

    <h1><?php echo htmlspecialchars($package['title']); ?></h1>
    
    <div class="package-gallery" style="margin-bottom: 20px;">
        <?php if (!empty($images)): ?>
            <div class="main-image">
                <img src="<?php echo htmlspecialchars($images[0]); ?>" alt="<?php echo htmlspecialchars($package['title']); ?>" style="max-width: 100%; height: auto;">
            </div>
            <div class="thumbnail-strip" style="display: flex; gap: 10px; margin-top: 10px;">
                <?php foreach (array_slice($images, 1) as $img): // Skip the primary image ?>
                    <img src="<?php echo htmlspecialchars($img); ?>" alt="Thumbnail" style="width: 100px; height: 70px; object-fit: cover; border: 1px solid #ccc;">
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>No images available for this package.</p>
        <?php endif; ?>
    </div>
    
    <div class="package-info">
        <div class="summary-box" style="float: right; width: 30%; border: 1px solid #ddd; padding: 15px;">
            <h3>Quick Facts</h3>
            <p><strong>Destination:</strong> <?php echo htmlspecialchars($package['destination']); ?></p>
            <p><strong>Duration:</strong> <?php echo htmlspecialchars($package['duration']); ?></p>
            <p class="price-large">Price: **$<?php echo htmlspecialchars(number_format($package['price'], 0)); ?>**</p>
            <a href="booking_enquiry.php?destination=<?php echo urlencode($package['title']); ?>" class="btn btn-book-now">Book / Enquire Now</a>
        </div>

        <h2>Package Description</h2>
        <p><?php echo nl2br(htmlspecialchars($package['description'])); ?></p>
        
        <h2>Highlights</h2>
        <ul><li><?php echo str_replace("\n", "</li><li>", htmlspecialchars($package['highlights'])); ?></li></ul>
        
        <h2>Inclusions & Exclusions</h2>
        <div class="details-cols" style="display: flex; gap: 40px;">
            <div style="width: 45%;">
                <h3>✅ Inclusions</h3>
                <ul><li><?php echo str_replace("\n", "</li><li>", htmlspecialchars($package['inclusion'])); ?></li></ul>
            </div>
            <div style="width: 45%;">
                <h3>❌ Exclusions</h3>
                <ul><li><?php echo str_replace("\n", "</li><li>", htmlspecialchars($package['exclusion'])); ?></li></ul>
            </div>
        </div>
    </div>

<?php include('admin/includes/footer.php'); ?>