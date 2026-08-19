<?php
require_once('includes/check_login.php'); 
require_once('../config/db.php'); 

$packages = [];

try {
    // Fetch all package data
    $sql = "SELECT id, title, destination, price, duration, created_at FROM packages ORDER BY created_at DESC";
    $stmt = $pdo->query($sql);
    $packages = $stmt->fetchAll();
} catch (PDOException $e) {
    $error = "Database Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Packages</title>
</head>
<body>
    <?php include('includes/admin_header.php'); ?>
    
    <h1>Manage Tour Packages</h1>
    
    <div style="margin-bottom: 20px;">
        <a href="add_package.php" style="padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px;">
            ➕ Add New Package
        </a>
    </div>

    <?php if (isset($error)) echo '<p style="color:red;">' . $error . '</p>'; ?>

    <?php if (empty($packages)): ?>
        <p>No travel packages have been added yet.</p>
    <?php else: ?>
        <table border="1" cellpadding="10" width="100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Destination</th>
                    <th>Duration</th>
                    <th>Price (USD)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($packages as $pkg): ?>
                <tr>
                    <td><?php echo htmlspecialchars($pkg['id']); ?></td>
                    <td><?php echo htmlspecialchars($pkg['title']); ?></td>
                    <td><?php echo htmlspecialchars($pkg['destination']); ?></td>
                    <td><?php echo htmlspecialchars($pkg['duration']); ?></td>
                    <td>$<?php echo htmlspecialchars(number_format($pkg['price'], 2)); ?></td>
                    <td>
                        <a href="edit_package.php?id=<?php echo $pkg['id']; ?>">Edit</a> | 
                        <a href="delete_package.php?id=<?php echo $pkg['id']; ?>" 
                           onclick="return confirm('Are you sure you want to delete this package and all associated images?');">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
    
    <?php include('includes/admin_footer.php'); ?>
</body>
</html>