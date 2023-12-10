<?php

include_once 'connectdb.php';
session_start();

<<<<<<< HEAD
if ($_SESSION['useremail'] == "") {
    header('location:../index.php');
}

if ($_SESSION['role'] == "Admin") {
    include_once "header.php";
} else {
    include_once "headeruser.php";
}

// 1 step) When the user clicks on the update password button, we get the values from the user into PHP variables
if (isset($_POST['btnupdate'])) {
    $oldpassword_txt = $_POST['txt_oldpassword'];
    $newpassword_txt = $_POST['txt_newpassword'];
    $rnewpassword_txt = $_POST['txt_rnewpassword'];

    // Check for empty fields
    if (empty($oldpassword_txt) || empty($newpassword_txt) || empty($rnewpassword_txt)) {
        $_SESSION['status'] = "Please fill in all fields";
        $_SESSION['status_code'] = "error";
    } else {
        // 2 step) Using a select query, we get our database records according to user email
        $email = $_SESSION['useremail'];
        $select = $pdo->prepare("SELECT * FROM tbl_user WHERE useremail=:email");
        $select->bindParam(':email', $email);
        $select->execute();
        $row = $select->fetch(PDO::FETCH_ASSOC);

        $useremail_db = $row['useremail'];
        $password_db = $row['userpassword'];

        // 3 step) We compare the user input values to database values
        if ($oldpassword_txt == $password_db) {
            if ($newpassword_txt == $rnewpassword_txt) {
                // 4 step) If values match, we run the update query
                $update = $pdo->prepare("UPDATE tbl_user SET userpassword=:pass WHERE useremail=:email");
                $update->bindParam(':pass', $rnewpassword_txt);
                $update->bindParam(':email', $email);

                if ($update->execute()) {
                    $_SESSION['status'] = "Password Updated Successfully";
                    $_SESSION['status_code'] = "success";
                } else {
                    $_SESSION['status'] = "Password not Updated Successfully";
                    $_SESSION['status_code'] = "error";
                }
            } else {
                $_SESSION['status'] = "New Password does not match";
                $_SESSION['status_code'] = "error";
            }
        } else {
            $_SESSION['status'] = "Old Password is incorrect";
            $_SESSION['status_code'] = "error";
        }
    }
}

=======

if($_SESSION['useremail']==""){

  header('location:../index.php');

}
if($_SESSION['role']=="Admin"){

  
  include_once"header.php";


}else{

include_once"headeruser.php";

}

// 1 step) When user click on updatepassword button then we get out values from user into php variables


if(isset($_POST['btnupdate'])){

$oldpassword_txt=$_POST['txt_oldpassword'];
$newpassword_txt=$_POST['txt_newpassword'];
$rnewpassword_txt=$_POST['txt_rnewpassword'];

//echo $oldpassword_txt."-".$newpassword_txt."-".$rnewpassword_txt;




// 2 step) Using of select Query we will get our database records  according to useremail.


$email = $_SESSION['useremail'];

$select =$pdo->prepare("select * from tbl_user where useremail='$email'");

$select->execute();
$row=$select->fetch(PDO::FETCH_ASSOC);

  $useremail_db=$row['useremail'];
  $password_db=$row['userpassword'];



// 3 step) We will compare the user inputs values to database values


if($oldpassword_txt== $password_db){

if($newpassword_txt== $rnewpassword_txt){
  
  // 4 step) If values will match then we will run update Query.

$update=$pdo->prepare("update tbl_user set userpassword=:pass where useremail=:email");

$update->bindParam(':pass',$rnewpassword_txt);
$update->bindParam(':email', $email);


if($update->execute()){

  $_SESSION['status']="Password Updated Successfully";
  $_SESSION['status_code']="Success";

}else{

  $_SESSION['status']="Password not Updated Successfully";
  $_SESSION['status_code']="Error";

}

}else{

  $_SESSION['status']="New Password does not match";
  $_SESSION['status_code']="Error";

}

}else{

  $_SESSION['status']="New Password does not match";
  $_SESSION['status']="Error";

}



}


>>>>>>> a634244ec399d70a7b6c8e9b070fd66749c7d84e


?>
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Change Password</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <!-- <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Starter Page</li> -->
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">

            <!-- Horizontal Form -->
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Change Password</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form class="form-horizontal" action="" method="post">
                <div class="card-body">
                  <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Old Password</label>
                    <div class="col-sm-10">
                      <input type="password" class="form-control" id="inputPassword3" placeholder="Old Password" name="txt_oldpassword" >
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">New Password</label>
                    <div class="col-sm-10">
                      <input type="password" class="form-control" id="inputPassword3" placeholder="New Password" name="txt_newpassword" >
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Confirm  Password</label>
                    <div class="col-sm-10">
<<<<<<< HEAD
                      <input type="password" class="form-control" id="inputPassword3" placeholder="Confirm Password" name="txt_rnewpassword"  >
=======
                      <input type="password" class="form-control" id="inputPassword3" placeholder="Confirm Password" name="txt_rnewpassword" >
>>>>>>> a634244ec399d70a7b6c8e9b070fd66749c7d84e
                    </div>
                  </div>
                  
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-info" name="btnupdate">Update Password</button>
                  
                </div>
                <!-- /.card-footer -->
              </form>
            </div>
            <!-- /.card -->
              
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->



  <?php 
include_once"footer.php";
?>

<?php
<<<<<<< HEAD
if(isset($_SESSION['status']) && $_SESSION['status']!='') {
    ?>
    <script>
        Swal.fire({
            icon: '<?php echo ($_SESSION['status_code'] == "success" && $newpassword_txt != '' && $rnewpassword_txt != '') ? "success" : "error"; ?>',
            title: '<?php echo $_SESSION['status']; ?>'
        });
    </script>
    <?php
    unset($_SESSION['status']);
}
?>


 
=======

if(isset($_SESSION['status']) && $_SESSION['status']!='')

{

?>
<script>

      Swal.fire({
        icon: '<?php echo $_SESSION['status_code']; ?>',
        title: '<?php echo $_SESSION['status']; ?>'
      });

</script>

<?php

unset($_SESSION['status']);

}
 
?>

>>>>>>> a634244ec399d70a7b6c8e9b070fd66749c7d84e
