<?php
require_once('includes/check_login.php'); 
require_once('../config/db.php'); 

$enquiries = [];
$status_message = $_GET['status_message'] ?? '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'update_status') {
    $enquiry_id = filter_var($_POST['enquiry_id'], FILTER_SANITIZE_NUMBER_INT);
    $new_status = trim($_POST['new_status']);
    
    try {
        $sql = "UPDATE enquiries SET status = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$new_status, $enquiry_id]);
        $status_message = "Status updated successfully!";
        header("Location: view_enquiries.php?status_message=" . urlencode($status_message));
        exit;
    } catch (PDOException $e) {
        $status_message = "Error updating status: " . $e->getMessage();
    }
}

try {
    $sql = "SELECT id, name, destination, enquiry_date, num_persons, status FROM enquiries ORDER BY enquiry_date DESC";
    $stmt = $pdo->query($sql);
    $enquiries = $stmt->fetchAll();
} catch (PDOException $e) {
    $error = "Database Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>View Booking Enquiries</title>
</head>
<body>
    <?php include('includes/admin_header.php'); ?>
    
    <h1>Booking / Enquiry Requests</h1>
    
    <?php if (!empty($status_message)) echo '<p style="color:green;">' . htmlspecialchars($status_message) . '</p>'; ?>
    <?php if (isset($error)) echo '<p style="color:red;">' . $error . '</p>'; ?>

    <?php if (empty($enquiries)): ?>
        <p>No booking requests have been submitted yet.</p>
    <?php else: ?>
        <table border="1" cellpadding="10" width="100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Destination</th>
                    <th>Persons</th>
                    <th>Date Received</th>
                    <th>Status</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($enquiries as $enquiry): ?>
                <tr>
                    <td><?php echo htmlspecialchars($enquiry['id']); ?></td>
                    <td><?php echo htmlspecialchars($enquiry['name']); ?></td>
                    <td><?php echo htmlspecialchars($enquiry['destination']); ?></td>
                    <td><?php echo htmlspecialchars($enquiry['num_persons']); ?></td>
                    <td><?php echo htmlspecialchars($enquiry['enquiry_date']); ?></td>
                    <td>
                        <form action="view_enquiries.php" method="post" style="display:inline;">
                            <input type="hidden" name="action" value="update_status">
                            <input type="hidden" name="enquiry_id" value="<?php echo $enquiry['id']; ?>">
                            <select name="new_status" onchange="this.form.submit()">
                                <?php 
                                    $statuses = ['New', 'Contacted', 'In Progress', 'Closed'];
                                    foreach ($statuses as $s) {
                                        $selected = ($s == $enquiry['status']) ? 'selected' : '';
                                        echo "<option value='{$s}' {$selected}>{$s}</option>";
                                    }
                                ?>
                            </select>
                        </form>
                    </td>
                    <td><a href="#details-<?php echo $enquiry['id']; ?>" onclick="alert('Full details: Email, Phone, Message, etc. (Implement modal/expand feature here)');">View</a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
    
    <?php include('includes/admin_footer.php'); ?>
</body>
</html>