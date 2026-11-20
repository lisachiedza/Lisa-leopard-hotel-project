<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') respond(false, 'Invalid request.');

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$msg = trim($_POST['message'] ?? '');

if (!$name || !$msg) respond(false, 'Please fill in all fields.');
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) respond(false, 'Invalid email address.');

try {
    $stmt = getDB()->prepare('INSERT INTO enquiries (name,email,message) VALUES (?,?,?)');
    $stmt->execute([$name, $email, $msg]);
    respond(true, 'Message sent successfully! We will reply soon.');
} catch (Exception $e) {
    error_log('Enquiry insert failed: ' . $e->getMessage());
    respond(false, 'Could not send message, please try again.');
}
