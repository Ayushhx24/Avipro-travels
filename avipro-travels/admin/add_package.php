<?php
require_once('includes/check_login.php'); // Security Guard
require_once('../config/db.php');        // Database Connection

$success_message = '';
$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $title = trim($_POST['title']);
        $destination = trim($_POST['destination']);
        $duration = trim($_POST['duration']);
        $price = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $description = trim($_POST['description']);
        $highlights = trim($_POST['highlights']);
        $inclusion = trim($_POST['inclusion']);
        $exclusion = trim($_POST['exclusion']);
        if (empty($title) || empty($price) || !is_numeric($price)) {
            throw new Exception("Title and valid Price are required fields.");
        }
        $pdo->beginTransaction();

        $sql_pkg = "INSERT INTO packages (title, destination, duration, price, description, highlights, inclusion, exclusion) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_pkg = $pdo->prepare($sql_pkg);
        $stmt_pkg->execute([$title, $destination, $duration, $price, $description, $highlights, $inclusion, $exclusion]);

        $package_id = $pdo->lastInsertId();
        $upload_dir = '../uploads/packages/'; 
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true); 
        }
        
        $is_primary_set = false;
        
        if (isset($_FILES['images']) && is_array($_FILES['images']['tmp_name'])) {
            
            foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
                if ($_FILES['images']['error'][$key] == UPLOAD_ERR_OK && is_uploaded_file($tmp_name)) {
                    
                    $file_ext = strtolower(pathinfo($_FILES['images']['name'][$key], PATHINFO_EXTENSION));
                    $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

                    if (in_array($file_ext, $allowed_ext)) {
                        
                        $new_file_name = uniqid('pkg_', true) . '.' . $file_ext;
                        $file_path = $upload_dir . $new_file_name;

                        if (move_uploaded_file($tmp_name, $file_path)) {
                            
                            $is_primary = 0;
                            if ($key == 0 && !$is_primary_set) {
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
        $success_message = "New Travel Package added successfully!";
        header("Location: add_package.php?status=success"); 
        exit;

    } catch (Exception $e) {
        $pdo->rollBack();
        $error_message = "Failed to add package: " . $e->getMessage();
    }
}

if (isset($_GET['status']) && $_GET['status'] == 'success') {
    $success_message = "New Travel Package added successfully!";
}
?>  

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add New Package</title>
</head>
<body>
    <?php include('includes/admin_header.php'); ?>
    
    <h1>Add New Travel Package</h1>
    
    <?php 
    if (!empty($success_message)) {
        echo '<p style="color:green;">' . $success_message . '</p>';
    }
    if (!empty($error_message)) {
        echo '<p style="color:red;">' . $error_message . '</p>';
    } 
    ?>

    <form action="add_package.php" method="post" enctype="multipart/form-data">
        
        <fieldset>
            <legend>Package Details</legend>
            <div>
                <label for="title">Package Title (Required):</label>
                <input type="text" name="title" id="title" required>
            </div>
            <div>
                <label for="destination">Destination:</label>
                <input type="text" name="destination" id="destination">
            </div>
            <div>
                <label for="duration">Duration (e.g., 5 Days / 4 Nights):</label>
                <input type="text" name="duration" id="duration">
            </div>
            <div>
                <label for="price">Price (Required - USD):</label>
                <input type="number" name="price" id="price" step="0.01" required>
            </div>
            <div>
                <label for="description">Detailed Description:</label>
                <textarea name="description" id="description" rows="5"></textarea>
            </div>
        </fieldset>
        
        <fieldset>
            <legend>Inclusions, Exclusions, and Highlights (One item per line)</legend>
            <div>
                <label for="highlights">Highlights:</label>
                <textarea name="highlights" id="highlights" rows="3"></textarea>
            </div>
            <div>
                <label for="inclusion">Inclusions:</label>
                <textarea name="inclusion" id="inclusion" rows="3"></textarea>
            </div>
            <div>
                <label for="exclusion">Exclusions:</label>
                <textarea name="exclusion" id="exclusion" rows="3"></textarea>
            </div>
        </fieldset>

        <fieldset>
            <legend>Package Images</legend>
            <div>
                <label for="images">Select Multiple Images (First one will be set as Primary):</label>
                <input type="file" name="images[]" id="images" multiple accept="image/*" required>
            </div>
        </fieldset>

        <div style="margin-top: 20px;">
            <input type="submit" value="Save Package">
        </div>
    </form>
    
    <?php include('includes/admin_footer.php'); ?>
</body>
</html>

                    