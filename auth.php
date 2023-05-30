<?php

use Inc\InputValidator;
use Inc\XssProtection;

require_once __DIR__ . "/inc/include.php";

if($auth->getUser()) {
  return header("Location: ./dashboard");
}

if(isset($_POST)) {
  $inputs   = XssProtection::sanitizeInput($_POST);
  $email    = $inputs['email'];
  $password = $inputs['password'];
  $remember = filter_var($inputs['remember'], FILTER_VALIDATE_BOOLEAN);

  # Validate form
  $validator = new InputValidator();
  $validator->validateEmail($email);
  $validator->validateMinLength($email, 5);
  $validator->validateRequired($email, 5);
  $validator->validateRequired($password);
  $validator->validateMinLength($password, 8);

  // Validate it
  if($validator->isValid()) {
    // Attempt try login
    if($auth->attempt(['email' => $email, 'password' => $password], $remember)) {
      return header("Location: ./dashboard");
    } else {
      $_SESSION['errors'] = "Woops, email or password isn't valid or not found on our records! Recheck again your credential before continue!";
    }
  } else {
    $_SESSION['errors'] = $validator->getErrors();
    return header("Location: ./login.php");
  }
}