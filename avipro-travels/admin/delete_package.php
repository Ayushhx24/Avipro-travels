<?php
require_once('includes/check_login.php');
require_once('../config/db.php');

$package_id = $_GET['id'] ?? null;

if ($package_id) {
    try {
        $pdo->beginTransaction();
        $sql_paths = "SELECT image_path FROM package_images WHERE package_id = ?";
        $stmt_paths = $pdo->prepare($sql_paths);
        $stmt_paths->execute([$package_id]);
        $image_paths = $stmt_paths->fetchAll(PDO::FETCH_COLUMN);

        foreach ($image_paths as $path) {
            $full_path = '../' . $path; 
            if (file_exists($full_path)) {
                unlink($full_path); 
            }
        }
        $sql_del_pkg = "DELETE FROM packages WHERE id = ?";
        $pdo->prepare($sql_del_pkg)->execute([$package_id]);

        $pdo->commit();
        $message = "Package and all associated files deleted successfully.";

    } catch (PDOException $e) {
        $pdo->rollBack();
        $message = "Database Error: Failed to delete package. " . $e->getMessage();
    }
} else {
    $message = "Invalid package ID provided.";
}

header("Location: manage_packages.php?status=" . urlencode($message));
exit;
?>