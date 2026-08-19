<?php
require_once('includes/check_login.php');
require_once('../config/db.php');

$package_id = $_GET['id'] ?? null;
$success_message = '';
$error_message = '';
$package = null;
$images = [];

if ($package_id) {
    try {
        $sql_pkg = "SELECT * FROM packages WHERE id = ?";
        $stmt_pkg = $pdo->prepare($sql_pkg);
        $stmt_pkg->execute([$package_id]);
        $package = $stmt_pkg->fetch();
        
        if (!$package) {
            $error_message = "Package not found.";
            $package_id = null; 
        }
        $sql_img = "SELECT id, image_path, is_primary FROM package_images WHERE package_id = ?";
        $stmt_img = $pdo->prepare($sql_img);
        $stmt_img->execute([$package_id]);
        $images = $stmt_img->fetchAll();

    } catch (PDOException $e) {
        $error_message = "Database Error while fetching: " . $e->getMessage();
        $package_id = null;
    }
} else {
    $error_message = "Invalid package ID provided.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && $package_id) {
    try {
        $title = trim($_POST['title']);
        $destination = trim($_POST['destination']);
        $duration = trim($_POST['duration']);
        $price = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $description = trim($_POST['description']);
        $highlights = trim($_POST['highlights']);
        $inclusion = trim($_POST['inclusion']);
        $exclusion = trim($_POST['exclusion']);
        
        if (empty($title) || empty($price)) {
            throw new Exception("Title and Price are required fields.");
        }

        $pdo->beginTransaction();
        $sql_update = "UPDATE packages SET title=?, destination=?, duration=?, price=?, description=?, highlights=?, inclusion=?, exclusion=? WHERE id=?";
        $stmt_update = $pdo->prepare($sql_update);
        $stmt_update->execute([$title, $destination, $duration, $price, $description, $highlights, $inclusion, $exclusion, $package_id]);

        if (isset($_POST['delete_images']) && is_array($_POST['delete_images'])) {
            foreach ($_POST['delete_images'] as $image_id) {
                $sql_fetch_path = "SELECT image_path FROM package_images WHERE id = ?";
                $stmt_path = $pdo->prepare($sql_fetch_path);
                $stmt_path->execute([$image_id]);
                $path = $stmt_path->fetchColumn();

                if ($path) {
                    $full_path = '../' . $path;
                    if (file_exists($full_path)) {
                        unlink($full_path); 
                    $sql_del_img = "DELETE FROM package_images WHERE id = ?";
                    $pdo->prepare($sql_del_img)->execute([$image_id]);
                }
            }
        }
        
        $upload_dir = '../uploads/packages/';
        if (isset($_FILES['new_images'])) {
            $is_primary_set = false;
            foreach ($_FILES['new_images']['tmp_name'] as $key => $tmp_name) {
                if ($_FILES['new_images']['error'][$key] == UPLOAD_ERR_OK) {
                    $file_ext = strtolower(pathinfo($_FILES['new_images']['name'][$key], PATHINFO_EXTENSION));
                    $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

                    if (in_array($file_ext, $allowed_ext)) {
                        $new_file_name = uniqid('pkg_', true) . '.' . $file_ext;
                        $file_path = $upload_dir . $new_file_name;

                        if (move_uploaded_file($tmp_name, $file_path)) {
                            $is_primary = 0;
                            if (!$is_primary_set && count($images) == 0 && $key == 0) {
                                $is_primary = 1;
                                $is_primary_set = true;
                            }
                            
                            $sql_img = "INSERT INTO package_images (package_id, image_path, is_primary) VALUES (?, ?, ?)";
                            $pdo->prepare($sql_img)->execute([$package_id, 'uploads/packages/' . $new_file_name, $is_primary]);
                        }
                    }
                }
            }
        }
        
        $pdo->commit();
        header("Location: edit_package.php?id={$package_id}&status=success"); 
        exit;

    } catch (Exception $e) {
        $pdo->rollBack();
        $error_message = "Update failed: " . $e->getMessage();
    }
}

if ($package_id) {
    try {
        $sql_pkg = "SELECT * FROM packages WHERE id = ?";
        $stmt_pkg = $pdo->prepare($sql_pkg);
        $stmt_pkg->execute([$package_id]);
        $package = $stmt_pkg->fetch();
        
        $sql_img = "SELECT id, image_path, is_primary FROM package_images WHERE package_id = ?";
        $stmt_img = $pdo->prepare($sql_img);
        $stmt_img->execute([$package_id]);
        $images = $stmt_img->fetchAll();
    } catch (PDOException $e) {
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Package: <?php echo htmlspecialchars($package['title'] ?? 'N/A'); ?></title>
</head>
<body>
    <?php include('includes/admin_header.php'); ?>
    
    <h1>Edit Travel Package: <?php echo htmlspecialchars($package['title'] ?? 'N/A'); ?></h1>
    
    <?php 
    if (!empty($_GET['status']) && $_GET['status'] == 'success') {
        echo '<p style="color:green;">Package updated successfully!</p>';
    }
    if (!empty($error_message)) {
        echo '<p style="color:red;">' . $error_message . '</p>';
    } 
    ?>

    <?php if ($package_id && $package): ?>
    
    <form action="edit_package.php?id=<?php echo $package_id; ?>" method="post" enctype="multipart/form-data">
        
        <fieldset>
            <legend>Package Details</legend>
            <div>
                <label for="title">Title (Required):</label>
                <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($package['title']); ?>" required>
            </div>
            <div>
                <label for="destination">Destination:</label>
                <input type="text" name="destination" id="destination" value="<?php echo htmlspecialchars($package['destination']); ?>">
            </div>
            <div>
                <label for="duration">Duration:</label>
                <input type="text" name="duration" id="duration" value="<?php echo htmlspecialchars($package['duration']); ?>">
            </div>
            <div>
                <label for="price">Price (Required):</label>
                <input type="number" name="price" id="price" step="0.01" value="<?php echo htmlspecialchars($package['price']); ?>" required>
            </div>
            <div>
                <label for="description">Detailed Description:</label>
                <textarea name="description" id="description" rows="5"><?php echo htmlspecialchars($package['description']); ?></textarea>
            </div>
        </fieldset>
        
        <fieldset>
            <legend>Highlights, Inclusions, and Exclusions</legend>
             <div>
                <label for="highlights">Highlights (One item per line):</label>
                <textarea name="highlights" id="highlights" rows="3"><?php echo htmlspecialchars($package['highlights']); ?></textarea>
            </div>
            <div>
                <label for="inclusion">Inclusions (One item per line):</label>
                <textarea name="inclusion" id="inclusion" rows="3"><?php echo htmlspecialchars($package['inclusion']); ?></textarea>
            </div>
            <div>
                <label for="exclusion">Exclusions (One item per line):</label>
                <textarea name="exclusion" id="exclusion" rows="3"><?php echo htmlspecialchars($package['exclusion']); ?></textarea>
            </div>
        </fieldset>

        <hr>
        <h2>🖼️ Image Management</h2>
        
        <?php if (!empty($images)): ?>
            <p>Check the box next to an image to **delete** it upon saving the package. (Note: A primary image must remain if others are deleted.)</p>
            <div style="display:flex; flex-wrap:wrap; gap:15px; margin-bottom: 20px;">
                <?php foreach ($images as $img): ?>
                <div style="border:1px solid #ccc; padding:10px; width:180px; text-align:center;">
                    <img src="../<?php echo htmlspecialchars($img['image_path']); ?>" style="width:100%; height:auto;" alt="Package Image">
                    <p style="margin:5px 0; font-size:12px; color: <?php echo $img['is_primary'] ? 'blue' : 'gray'; ?>;">
                        <?php echo $img['is_primary'] ? 'PRIMARY' : 'Secondary'; ?>
                    </p>
                    <label>
                        <input type="checkbox" name="delete_images[]" value="<?php echo $img['id']; ?>"> Delete
                    </label>
                </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>No images associated with this package. Please upload new ones below.</p>
        <?php endif; ?>

        <fieldset style="margin-top: 20px;">
            <legend>Upload New Images</legend>
            <label for="new_images">Select files to add:</label>
            <input type="file" name="new_images[]" id="new_images" multiple accept="image/*">
        </fieldset>

        <div style="margin-top: 30px;">
            <input type="submit" value="Save Changes">
            <a href="manage_packages.php" style="margin-left: 20px;">Cancel</a>
        </div>
    </form>
    
    <?php else: ?>
        <p>Could not load package details. Please check the ID or database connection.</p>
    <?php endif; ?>
    
    <?php include('includes/admin_footer.php'); ?>
</body>
</html>