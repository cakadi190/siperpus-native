<?php

use Inc\XssProtection;

require_once "../../inc/include.php";

// User Middleware
if(!$auth->getUser()) {
  $_SESSION['errors'] = ['Sorry! You are not allowed to access that page before you authenticated!'];
  return header("Location: ../login.php");
}

// Get User Data
$user = $auth->getUser();
if($user['role'] !== 'admin') {
  return header('Location: ../dashboard');
}

// Sanitize process
$id = XssProtection::validateInput($_GET['id']);

$stmt = $db->getConnection()->prepare('DELETE FROM books WHERE id = ?');
$stmt->bind_param('s', $id);
$stmt->execute();

return header("Location: ./");
