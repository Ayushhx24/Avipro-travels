// File: process_booking.php (Place this file in the root directory)

<?php
require_once('config/db.php'); 
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit;
}
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$destination = trim($_POST['destination'] ?? '');
$travel_date = trim($_POST['travel_date'] ?? '');
$num_persons = filter_var($_POST['num_persons'] ?? 0, FILTER_SANITIZE_NUMBER_INT);
$message = trim($_POST['message'] ?? '');

$errors = [];
if (empty($name)) $errors[] = "Name is required.";
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "A valid Email is required.";
if (empty($phone)) $errors[] = "Phone number is required.";
if (empty($destination)) $errors[] = "Destination is required.";
if (empty($travel_date)) $errors[] = "Travel Date is required.";
if ($num_persons <= 0) $errors[] = "Number of Persons must be greater than zero.";

if (!empty($errors)) {
    echo json_encode(['status' => 'error', 'message' => 'Validation Failed on server.', 'errors' => $errors]);
    exit;
}

try {
    $sql = "INSERT INTO enquiries (name, email, phone, destination, travel_date, num_persons, message) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
            
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $name, 
        $email, 
        $phone, 
        $destination, 
        $travel_date, 
        $num_persons, 
        $message
    ]);

    echo json_encode(['status' => 'success', 'message' => 'Your booking enquiry has been successfully received. We will contact you soon!']);

} catch (PDOException $e) {
    error_log("Enquiry Insert Error: " . $e->getMessage()); 
    echo json_encode(['status' => 'error', 'message' => 'A database error occurred. Please try again later.']);
}
exit;
?>