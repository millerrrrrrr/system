<?php
include_once 'ui/connectdb.php';


if (isset($_POST['btn_submit'])) {

  $useremailOrusername = $_POST['txt_email'];
  $password = $_POST['txt_password'];

  $select = $pdo->prepare("SELECT * FROM tbl_user WHERE (useremail=:useremail OR username=:username) AND userpassword=:password");
  $select->bindParam(':username', $useremailOrusername);
  $select->bindParam(':useremail', $useremailOrusername);
  $select->bindParam(':password', $password);
  $select->execute();

  $row = $select->fetch(PDO::FETCH_ASSOC);

  if (is_array($row)) {

    if ($row['useremail'] == $useremailOrusername || $row['username'] == $useremailOrusername) {

      $_SESSION['userid'] = $row['userid'];
      $_SESSION['username'] = $row['username'];
      $_SESSION['useremail'] = $row['useremail'];
      $_SESSION['role'] = $row['role'];

      if ($row['role'] == 'Admin') {
        $_SESSION['status'] = "Login Success by Admin";
        $_SESSION['status_code'] = "success";
        header('refresh: 1; ui/dashboard.php');
      } elseif ($row['role'] == 'User') {
        $_SESSION['status'] = "Login Success by User";
        $_SESSION['status_code'] = "success";
        header('refresh: 1; ui/user.php');
      }
    }
  } else {

    $_SESSION['status'] = "Wrong email or password";
    $_SESSION['status_code'] = "error";
  }
}
?>





<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>POS MIL | Log in</title>

  
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->

  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="plugins/toastr/toastr.min.css">

  <link rel="stylesheet" href="dist/css/adminlte.min.css">

  <style>
    .login-page {
      background-color: black;
    }

    .card-body {
      background-color: #0C2D57;
      color: white;
      border-radius: 0 0 20px 20px;
    }

    .card-header {
      background-color: #0C2D57;
      color: white;
      border-radius: 20px 20px 0 0;

    }

    .card {
      background-color: black;
    }
  </style>



</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card ">
      <div class="card-header text-center">
        <a href="#" class="h1"><b>POS MIL</b></a>
      </div>
      <div class="card-body">
        <p class="login-box-msg">Sign in to start your session</p>

        <form action="" method="post">
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Email" name="txt_email" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
            <div class="input-group mb-3">
            </div>
            <input type="password" class="form-control" placeholder="Password" name="txt_password" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-8">
              <div class="icheck-primary">
                <a href="#">I forgot my password</a>
              </div>
            </div>
            <!-- /.col -->
            <!-- < div class="col-4"> -->
              <button type="submit" class="btn btn-primary btn-block" name="btn_submit">Log In</button>
          </div>
          <!-- /.col -->
      </div>
      <div c lass="row">
        <div class="col-12">
          <a href="#">Register an account?</a>
        </div>
        </ div>
        </form>


        <!-- /.social-auth-links -->

        <p class="mb-1">

        </p>
        <p class="mb-0">

        </p>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>

  <!-- SweetAlert2 -->
  <script src="plugins/sweetalert2/sweetalert2.min.js"></script>
  <!-- Toastr -->
  <script src="plugins/toastr/toastr.min.js"></script>

</body>

</html>


<?php
if (isset($_SESSION['status']) && $_SESSION['status'] != '') {
?>

  <script>
    $(function() {
      var Toast = Swal.mixin({
        toast: true,
        position: 'top',
        showConfirmButton: false,
        timer: 5000
      });


      Toast.fire({
        icon: '<?php echo $_SESSION['status_code'] ?>',
        title: '<?php echo $_SESSION['status'] ?>'
      })
    })
  </script>

<?php
  unset($_SESSION['status']);
}

?>