<?php

use Inc\XssProtection;

require_once "../../inc/include.php";

// User Middleware
if(!$auth->getUser()) {
  $_SESSION['errors'] = ['Sorry! You are not allowed to access that page before you authenticated!'];
  return header("Location: ../../login.php");
}

// User get Data
$user = $auth->getUser();

// Insertion process
$id = XssProtection::validateInput($_GET['id']);

// Update Data
$db->update('penalties', ['paid_status' => 2, 'paid_date' => date('Y-m-d H:i:s')], "id = '{$id}'");

// Return it back
return header("Location: ./");