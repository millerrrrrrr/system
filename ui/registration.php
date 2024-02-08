<?php

include_once "connectdb.php";
session_start();


if ($_SESSION['useremail'] == '' OR $_SESSION['role'] == 'User') {
    header('location:../index.php');
  }
  
  if ($_SESSION['role'] == 'Admin') {
    include_once "header.php";
  } else {
    include_once "headeruser.php";
  }
  

error_reporting(0);

$id = $_GET['id'];

if(isset($id)){
    $delete = $pdo -> prepare("delete from tbl_user where userid =".$id);

    if($delete -> execute()){
        $statusMessage = "Account deleted successfully.";
        $statusCode = 'success';
    }else{
        $statusMessage = "Account was not deleted.";
        $statusCode = 'error';
    }

    $_SESSION['status'] = $statusMessage;
    $_SESSION['status_code'] = $statusCode;
} 



if(isset($_POST['btn_save'])){
    $username = $_POST['name'];
    $userage = $_POST['age'];
    $useremail = $_POST['email'];
    $useraddress = $_POST['address'];
    $usercontact = $_POST['contact'];
    $userpassword = $_POST['password'];
    $userrole = $_POST['select_option'];

    if(isset($_POST['email']) && isset($_POST['password'])){

        $selectEmail = $pdo -> prepare("select useremail from tbl_user where useremail='$useremail'");
        $selectPassword = $pdo -> prepare("select userpassword from tbl_user where userpassword='$userpassword'");


        $selectEmail -> execute();
        $selectPassword -> execute();

        

        if($selectEmail->rowCount()>0){
            $statusMessage = "Email already exists.";
            $statusCode = 'warning';
        } elseif($selectPassword->rowCount()>0) {
            $statusMessage = "Password already exists.";
            $statusCode = 'warning';
        }elseif($_POST['age'] <= 17){
            $statusMessage = "Sorry, you must be 17 or older to register an account.";
            $statusCode = 'warning';




        }else{

            $insert = $pdo -> prepare("insert into tbl_user (username,userage,useremail,useraddress,usercontact,userpassword,role) values(:name,:age,:email,:address,:contact,:password,:role)");

            $insert->bindParam(':name',$username);
            $insert->bindParam(':age',$userage);
            $insert->bindParam(':email',$useremail);
            $insert->bindParam(':address',$useraddress);
            $insert->bindParam(':contact',$usercontact);
            $insert->bindParam(':password',$userpassword);
            $insert->bindParam(':role',$userrole);
        
            if($insert->execute()){
                $statusMessage = "Registered successfully.";
                $statusCode = 'success';
            }else{
                $statusMessage = "There was a problem registering the user";
                $statusCode = 'error';
            }
        }
        $_SESSION['status'] = $statusMessage;
        $_SESSION['status_code'] = $statusCode;
    }

}



?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Registration</h1>
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

            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="m-0">Registration Form</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">

                            <form action="" method="POST">
                                <div class="card-body">

                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" class="form-control" placeholder="Enter Name" name="name" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Age</label>
                                        <input type="number" class="form-control" placeholder="Enter Age" name="age" min="1" max="99" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Email address</label>
                                        <input type="email" class="form-control" placeholder="Enter Email" name="email" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Address</label>
                                        <input type="text" class="form-control" placeholder="Enter Address" name="address" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Contact No.</label>
                                        <input type="number" class="form-control" placeholder="Enter Contact No." name="contact" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" class="form-control" placeholder="Password" name="password" required>
                                    </div>
                                    

                                    <div class="form-group">
                                        <label>Role</label>
                                        <select class="form-control" name="select_option" required>
                                            <option value="" disabled selected >Select Role</option>
                                            <option>Admin</option>
                                            <option>User</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary" name="btn_save">Save</button>
                                </div>
                            </form>

                        </div>
                        <div class="col-md-8">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <td>#</td>
                                        <td>Name</td>
                                        <td>Age</td>
                                        <td>Email</td>
                                        <td>Address</td>
                                        <td>Contact No.</td>
                                        <td>Password</td>
                                        <td>Role</td>
                                        <td>Delete</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $select = $pdo -> prepare('SELECT * from tbl_user ORDER BY userid ASC');
                                    $select->execute();

                                    while($row = $select -> fetch(PDO::FETCH_OBJ)){
                                        echo'
                                        <tr>
                                        <td>'.$row->userid.'</td>
                                        <td>'.$row->username.'</td>
                                        <td>'.$row->userage.'</td>
                                        <td>'.$row->useremail.'</td>
                                        <td>'.$row->useraddress.'</td>
                                        <td>'.$row->usercontact.'</td>
                                        <td>'.$row->userpassword.'</td>
                                        <td>'.$row->role.'</td>
                                        <td>
                                        <a href="#" class="btn btn-danger" onclick="confirmDelete(' . $row->userid . ');"><i class="fa fa-trash-alt"></i></a>
                                        </td>
                                        </tr>
                                        ';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div> 
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->




<?php
include_once "footer.php";
?>

<?php
if (isset($_SESSION['status']) && $_SESSION['status'] !== '') {
  $icon = $_SESSION['status_code'];
  $message = $_SESSION['status'];

  // Output JavaScript directly with values from PHP variables
  echo <<<HTML
    <script>
            Swal.fire({
                icon: '{$icon}',
                title: '{$message}'
            });
    </script>
HTML;

  unset($_SESSION['status']);
}
?>

<script>
    function confirmDelete(userId) {
        Swal.fire({
            title: "Are you sure?",
            text: "",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'registration.php?id=' + userId;
            }
        });
    }
</script>



