<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') respond(false, 'Invalid request.');

$name  = trim($_POST['full_name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$room  = trim($_POST['room_type'] ?? '');
$in    = $_POST['check_in'] ?? '';
$out   = $_POST['check_out'] ?? '';
$guests = (int)($_POST['guests'] ?? 1);

if (!$name || !$phone || !$room || !$in || !$out) respond(false, 'Please fill in all fields.');
if (!filter_var($email, FILTER_VALIDATE_EMAIL))   respond(false, 'Invalid email address.');
if (strtotime($out) <= strtotime($in))            respond(false, 'Check-out must be after check-in.');

try {
    $stmt = getDB()->prepare('INSERT INTO bookings (full_name,email,phone,room_type,check_in,check_out,guests)
                              VALUES (?,?,?,?,?,?,?)');
    $stmt->execute([$name, $email, $phone, $room, $in, $out, $guests]);
    respond(true, 'Successfully booked! Thank you, ' . htmlspecialchars($name) . '. We look forward to hosting you.');
} catch (Exception $e) {
    error_log('Booking insert failed: ' . $e->getMessage());
    respond(false, 'Booking failed, please try again.');
}
