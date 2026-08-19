
<?php 
require_once('config/db.php');
$banner_title = $pdo->query("SELECT setting_value FROM site_settings WHERE setting_key = 'banner_title'")->fetchColumn() ?: 'Plan Your Perfect Getaway with Avipro Travels';

$featured_packages = $pdo->query("SELECT id, title, destination, price FROM packages ORDER BY created_at DESC LIMIT 6")->fetchAll();
?>

<?php include('admin/includes/header.php'); ?>

    <section class="hero-banner">
        <h1><?php echo htmlspecialchars($banner_title); ?></h1>
        <p>Explore our curated list of destinations and find your dream vacation.</p>
        <a href="packages.php" class="btn btn-primary">View All Packages</a>
    </section>

    <section class="featured-packages">
        <h2>🔥 Our Best Selling Tours</h2>
        <div class="package-grid">
            <?php if (!empty($featured_packages)): ?>
                <?php foreach ($featured_packages as $pkg): 
                    $img_path_stmt = $pdo->prepare("SELECT image_path FROM package_images WHERE package_id = ? AND is_primary = 1 LIMIT 1");
                    $img_path_stmt->execute([$pkg['id']]);
                    $primary_image = $img_path_stmt->fetchColumn() ?: 'assets/images/placeholder.jpg';
                ?>
                <div class="package-card">
                    <img src="<?php echo htmlspecialchars($primary_image); ?>" alt="<?php echo htmlspecialchars($pkg['title']); ?>" style="width: 100%; height: 180px; object-fit: cover; margin-bottom: 10px;">
                    <h3><?php echo htmlspecialchars($pkg['title']); ?></h3>
                    <p>Destination: **<?php echo htmlspecialchars($pkg['destination']); ?>**</p>
                    <p class="price">Starting from: $<?php echo htmlspecialchars(number_format($pkg['price'], 0)); ?></p>
                    <a href="package_details.php?id=<?php echo $pkg['id']; ?>" class="btn btn-details">View Details</a>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No packages are currently featured. Please add some via the Admin Panel.</p>
            <?php endif; ?>
        </div>
    </section>

    <style>
    .hero-banner {
        text-align: center;
        padding: 60px 20px;
        background-color: #f5f5f5;
        margin-bottom: 40px;
    }
    .hero-banner:hover {
        background-color: #e0e0e0;
    }
    .featured-packages h2 {
        text-align: center;
        margin-bottom: 30px;
    }
    .package-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: center;
    }
    .package-card {
        border: 1px solid #ddd;
        padding: 15px;
        width: calc(33% - 20px);
        box-sizing: border-box;
        text-align: center;
        transition: box-shadow 0.3s ease;
    }
    .package-card:hover {
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .price {
        font-weight: bold;
        color: green;
        margin: 10px 0;
    }
    .btn-details {
        display: inline-block;
        padding: 8px 15px;
        background-color: #007bff;
        color: white;
        text-decoration: none;
        border-radius: 4px;
    }
    .btn-details:hover {
        background-color: #0056b3;
    }

    </style>

<?php include('admin/includes/footer.php'); ?>