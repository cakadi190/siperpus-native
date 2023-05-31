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
  $surname  = $inputs['surname'];

  # Validate form
  $validator = new InputValidator();
  $validator->validateEmail($email);
  $validator->validateMinLength($email, 5);
  $validator->validateRequired($email, 5);
  $validator->validateRequired($password);
  $validator->validateMinLength($password, 8);
  $validator->validateRequired($surname);
  $validator->validateMinLength($surname, 5);

  if($validator->isValid()) {
    $data = [
      'email'    => $email,
      'password' => password_hash($password, PASSWORD_DEFAULT),
      'surname'  => $surname,
      'role'     => 'users',
    ];
    $db->insert('users', $data);
    return header("Location: ./login.php");
  } else {
    $_SESSION['errors'] = $validator->getErrors();
    return header("Location: ./login.php");
  }
}