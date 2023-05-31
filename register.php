<?php

require_once __DIR__ . '/inc/include.php';

// The middleware
if ($auth->getUser()) {
  return header("Location: ./dashboard");
}
?><!DOCTYPE html>
<html lang="en">

<head>
  <base href="https://<?= $_SERVER['SERVER_NAME'] ?>/panel-assets/" />
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Register - Siperpus</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary d-flex align-items-center">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center min-vh-100 align-items-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image" style="background: url('https://images.unsplash.com/photo-1481627834876-b7833e8f5570?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=628&q=80') no-repeat center center;"></div>
              <div class="col-lg-6">
                <div class="p-5">

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

                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Register!</h1>
                  </div>
                  <form class="user" action="https://<?= $_SERVER['SERVER_NAME'] ?>/regist.php" method="POST">
                    <div class="form-group">
                      <input type="email" class="form-control form-control-user" placeholder="admin@gmail.com" id="email" name="email" />
                    </div>
                    <div class="form-group">
                      <input type="surname" class="form-control form-control-user" placeholder="Agus Tri Prasojo" id="surname" name="surname" />
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" placeholder="Your Password" id="password" name="password" />
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-user btn-block">Register</button>
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="https://<?= $_SERVER['SERVER_NAME'] ?>/login.php">Back to login</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

</body>

</html>