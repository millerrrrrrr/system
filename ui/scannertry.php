<?php

include_once 'connectdb.php';
session_start();

if ($_SESSION['username'] == "") {
    header('location:../login.php');
}

include_once "header.php";

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">QR Scanner</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">

                <!-- QR Scanner Column -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="m-0">Scan Your QR Code</h5>
                        </div>
                        <div class="card-body">
                            <div id="scanner" style="width:100%; height: 400px; border: 1px solid #ccc;"></div>

                            <div id="user-info" style="margin-top: 20px; padding: 10px; background-color: #f4f4f4; border-radius: 5px; display: none;">
                                <h6><strong>User Information:</strong></h6>
                                <p><strong>Name:</strong> <span id="user-name"></span></p>
                                <p><strong>Email:</strong> <span id="user-email"></span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.col-lg-6 -->

            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->







<?php

include_once "footer.php";

?>