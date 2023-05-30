<?php

use Inc\Template;

require_once __DIR__ . '/inc/include.php';

// The middleware
if($auth->getUser()) {
  return header("Location: ./dashboard");
} 
?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Authentication - Siperpus</title>

  <?=Template::getCSS(); ?>
  <?=Template::getJS(true); ?>
</head>
<body class="bg-light align-items-center justify-content-center">
  <div class="container">
    <div class="row min-vh-100 align-items-center justify-content-center">
      <div class="col-md-5">
        <div class="card shadow border-0">
          <h5 class="card-header py-3 bg-white">Hello Stranger!</h5>
          <div class="card-body">
            <p>Please enter your credential to continue.</p>

            <?php if(isset($_SESSION['errors'])) : ?>
            <div class="alert alert-danger">
              <h5>Warning!</h5>
              <ul class="mb-0">
                <?php foreach($_SESSION['errors'] as $error) : ?>
                <li><?=$error; ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
            <?php endif; ?>

            <form action="./auth.php" method="POST" class="pt-2">

              <!-- Form Email -->
              <div class="form-group mb-3">
                <div class="form-floating">
                  <input type="email" class="form-control" placeholder="admin@gmail.com" id="email" name="email" />
                  <label for="email">Email address</label>
                </div>
              </div>
              
              <!-- Form Password -->
              <div class="form-group mb-3">
                <div class="form-floating">
                  <input type="password" class="form-control" placeholder="admin@gmail.com" id="password" name="password" />
                  <label for="password">Your Password</label>
                </div>
              </div>

              <div class="d-flex justify-content-between align-items-center">
                <!-- Form Checkbox -->
                <div class="form-check">
                  <input type="checkbox" class="form-check-input" value="true" id="remember" name="remember" />
                  <label for="remember" class="form-check-label">Remember Me</label>
                </div>

                <!-- Submission button -->
                <button type="submit" class="btn btn-primary">Login</button>
              </div>
              
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>