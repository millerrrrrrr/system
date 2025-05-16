<?php
include_once "connectdb.php";
session_start();
include_once "header.php";
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <!-- <h1 class="m-0">Blank Dashboard</h1> -->
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
      <div class="row justify-content-center">
        <div class="col-lg-8">

          <!-- Card to hold the Student Details -->
          <div class="card shadow-sm mb-4">
            <div class="card-header  text-white" style="background-color:maroon;">
              <h5 class="m-0">View Student Details</h5>
            </div>
            <div class="card-body">

              <?php
              $id = $_GET['id'];

              $select = $pdo->prepare("SELECT * FROM tbl_student WHERE id = $id");
              $select->execute();

              while ($row = $select->fetch(PDO::FETCH_OBJ)) {

                echo '
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item bg-light text-dark text-center"><b>STUDENT DETAILS</b></li>
                                <li class="list-group-item"><b>Name</b><span class="float-right text-muted">' . $row->name . '</span></li>
                                <li class="list-group-item"><b>Lrn</b><span class="float-right text-muted">' . $row->lrn . '</span></li>
                                <li class="list-group-item"><b>Password</b><span class="float-right text-muted">' . $row->password . '</span></li>
                                <li class="list-group-item"><b>Grade</b><span class="float-right text-muted">' . $row->grade . '</span></li>
                                <li class="list-group-item"><b>Section</b><span class="float-right text-muted">' . $row->section . '</span></li>
                                <li class="list-group-item"><b>Guardian Name</b><span class="float-right text-muted">' . $row->gname . '</span></li>
                                <li class="list-group-item"><b>Address</b><span class="float-right text-muted">' . $row->address . '</span></li>
                                <li class="list-group-item"><b>Guardian Contact</b><span class="float-right text-muted">' . $row->gcontact . '</span></li>
                            </ul>
                        </div>

                        <div class="col-md-6 text-center">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item bg-light text-dark text-center"><b>STUDENT QR</b></li>
                                <li class="list-group-item">
                                    <img src="' . $row->image . '" class="img-fluid rounded shadow-sm" style="width: 100%; height: auto;" alt="Student QR">
                                    

                                </li>
                            </ul>
                        </div>
                    </div>
                    ';
              }
              ?>

            </div>
          </div>

        </div>
        <!-- /.col-lg-8 -->
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