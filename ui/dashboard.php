<?php

include_once 'connectdb.php';
session_start();

if ($_SESSION['username'] == "") {

  header('location:../login.php');
}

include_once "header.php";

$stmt = $pdo->prepare("SELECT COUNT(*) as total_students FROM tbl_student");
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$total_students = $row['total_students'];

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Dashboard</h1>
        </div><!-- /.col -->

      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="row">

        <!-- /.col-md-6 -->
        <div class="col-lg-6">
          <div class="card">
            <div class="card-header">
              <h5 class="m-0">Total Student Registered</h5>
            </div>
            <div class="card-body">
              <!-- <h6 class="card-title">Special title treatment</h6> -->
              <h3><?php echo $total_students; ?></h3>

              <!-- <p class="card-text">With supporting text below as a natural lead-in to additional content.</p> -->
              <!-- <a href="#" class="btn btn-primary">View</a> -->
            </div>
          </div>


        </div>
        <div class="col-lg-6">
          <div class="card">
            <div class="card-header">
              <h5 class="m-0">Total Attendance</h5>
            </div>
            <div class="card-body">
              <!-- <h6 class="card-title">Special title treatment</h6> -->

              <!-- <p class="card-text">With supporting text below as a natural lead-in to additional content.</p> -->
              <a href="#" class="btn btn-primary">View</a>
            </div>
          </div>


        </div>
        <div class="col-lg-6">
          <div class="card">
            <div class="card-header">
              <h5 class="m-0">Total Absents</h5>
            </div>
            <div class="card-body">
              <!-- <h6 class="card-title">Special title treatment</h6> -->

              <!-- <p class="card-text">With supporting text below as a natural lead-in to additional content.</p> -->
              <a href="#" class="btn btn-primary">View</a>
            </div>
          </div>


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

include_once "footer.php";

?>