<?php
include_once 'ui/connectdb.php';
session_start();

if (isset($_POST['btn_login'])) {

  $username = $_POST['username'];
  $password = $_POST['password'];

  $select = $pdo->prepare("SELECT * FROM tbl_admin WHERE username=:username AND password=:password");
  $select->bindParam(':username', $username);
  $select->bindParam(':password', $password);
  $select->execute();

  $row = $select->fetch(PDO::FETCH_ASSOC);

  if (is_array($row)) {

    if ($row['username'] == $username && $row['password'] == $password) {


      $_SESSION['username'] = $row['username'];


      $_SESSION['status'] = "Login Success by Admin";
      $_SESSION['status_code'] = "success";
      header('refresh: 1; ui/dashboard.php');
    }
  } else {

    $_SESSION['status'] = "Wrong username or password";
    $_SESSION['status_code'] = "error";
  }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>QR-Based Attendance</title>
  <link rel="stylesheet" href="login.css">


  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">

  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>

  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="plugins/toastr/toastr.min.css">




</head>

<body>
  <div class="container">
    <form class="login-form" action="" method="post">
      <h2>Admin Sign in</h2>
      <input type="text" placeholder="Username" name="username">
      <input type="password" placeholder="Password" name="password">
      <button name="btn_login">Login</button>
    </form>
    <div class="center-line"></div>
    <div class="image">

    </div>
  </div>



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