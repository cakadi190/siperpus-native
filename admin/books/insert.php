<?php

use Inc\XssProtection;

require_once "../../inc/include.php";

// User Middleware
if(!$auth->getUser()) {
  $_SESSION['errors'] = ['Sorry! You are not allowed to access that page before you authenticated!'];
  return header("Location: ../../login.php");
}

// Check if is post
if(isset($_POST)) {
  // XSS Protect
  $input = XssProtection::validateInput($_POST);
  
  $data = [ 'availability' => 'available' ];
  $mergedData = array_merge($data, $input);
  
  $db->insert('books', $mergedData);
  return header("Location: ./");
}