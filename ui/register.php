<?php
session_start();
include_once "header.php";
include_once "connectdb.php";








if (isset($_POST['btn_save'])) {
    $name = $_POST['name'];
    $lrn = $_POST['lrn'];
    $password = $_POST['password'];
    $grade = $_POST['select_grade'];
    $section = $_POST['select_section'];
    $gname = $_POST['guardian_name'];
    $address = $_POST['address'];
    $gcontact = $_POST['guardian_contact'];
    $qr = $_POST['qr'];

    if (isset($_POST['lrn']) && isset($_POST['name'])) {

        $selectLrn = $pdo->prepare("select lrn from tbl_students where lrn='$lrn'");
        $selectName = $pdo->prepare("select name from tbl_students where name='$name'");


        $selectLrn->execute();
        $selectName->execute();



        if ($selectLrn->rowCount() > 0) {
            $statusMessage = "Lrn already exists.";
            $statusCode = 'warning';
        } elseif ($selectName->rowCount() > 0) {
            $statusMessage = "Name already exists.";
            $statusCode = 'warning';
        } else {

            $insert = $pdo->prepare("insert into tbl_students (name,lrn,password,grade,section,gname,address,gcontact,qr) values(:name,:lrn,:password,:grade,:section,:gname,:address,:gcontact,:qr)");

            $insert->bindParam(':name', $name);
            $insert->bindParam(':lrn', $lrn);
            $insert->bindParam(':password', $password);
            $insert->bindParam(':grade', $grade);
            $insert->bindParam(':section', $section);
            $insert->bindParam(':gname', $gname);
            $insert->bindParam(':address', $address);
            $insert->bindParam(':gcontact', $gcontact);
            $insert->bindParam(':qr', $qr);

            if ($insert->execute()) {
                $statusMessage = "Registered successfully.";
                $statusCode = 'success';
            } else {
                $statusMessage = "There was a problem registering the user";
                $statusCode = 'error';
            }
        }
        $_SESSION['status'] = $statusMessage;
        $_SESSION['status_code'] = $statusCode;
    }
}



?>



<style>
    input[type="number"]::-webkit-outer-spin-button,
    input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type="number"] {
        -moz-appearance: textfield;
        /* For Firefox */
    }
</style>

<script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>

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

            <div class="card">
                <div class="card-header">
                    <h5 class="m-0">Registration Form</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">

                            <form action="" method="POST">
                                <div class="card-body">

                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" class="form-control" placeholder="Enter Name" name="name">
                                    </div>

                                    <div class="form-group">
                                        <label>Lrn</label>
                                        <input type="number" class="form-control" id="lrn" placeholder="Enter Lrn" name="lrn">
                                    </div>

                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="text" class="form-control" placeholder="Enter Password" name="password">
                                    </div>

                                    <!-- <div class="form-group">
                                        <label>Grade</label>
                                        <input type="text" class="form-control" placeholder="Enter Grade" name="grade">
                                    </div> -->

                                    <div class="form-group">
                                        <label>Grade</label>
                                        <select class="form-control" name="select_grade" id="grade" required>
                                            <option value="" disabled selected>Select Grade</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Section/Strand</label>
                                        <select class="form-control" name="select_section" id="section" required>
                                            <option value="" disabled selected>Select Section</option>
                                        </select>
                                    </div>


                                    <!-- <div class="form-group">
                                        <label>Section/Strand</label>
                                        <input type="text" class="form-control" placeholder="Enter Section/Strand" name="section">
                                    </div> -->

                                    <div class="form-group">
                                        <label>Guardian's Name</label>
                                        <input type="text" class="form-control" placeholder="Enter Guardian's Name" name="guardian_name">
                                    </div>



                                    <div class="form-group">
                                        <label>Address</label>
                                        <input type="text" class="form-control" placeholder="Enter Address" name="address">
                                    </div>

                                    <div class="form-group">
                                        <label>Guardian's Contact No.</label>
                                        <input type="number" class="form-control" placeholder="Enter Guardian's Contact No." name="guardian_contact">
                                    </div>

                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary" name="btn_save">Save</button>
                                </div>
                            </form>

                        </div>
                        <div class="col-md-6">
                            <label>Qr Code</label>
                            <div id="qr-code" name="qr"></div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>





<script>
    document.getElementById('grade').addEventListener('change', function() {
        var grade = this.value;
        var sectionDropdown = document.getElementById('section');

        // Clear previous options
        sectionDropdown.innerHTML = '<option value="" disabled selected>Select Section</option>';

        // Based on grade, add the relevant options to the section dropdown
        if (grade == '7') {
            var sections = ['Rose', 'Tulip', 'Lily', 'Daisy']; // 4 flowers for grade 7
            sections.forEach(function(section) {
                var option = document.createElement('option');
                option.value = section;
                option.textContent = section;
                sectionDropdown.appendChild(option);
            });
        } else if (grade == '8') {
            var sections = ['Ruby', 'Emerald', 'Sapphire', 'Diamond']; // 4 gems for grade 8
            sections.forEach(function(section) {
                var option = document.createElement('option');
                option.value = section;
                option.textContent = section;
                sectionDropdown.appendChild(option);
            });
        } else if (grade == '9') {
            var sections = ['Mercury', 'Venus', 'Earth', 'Mars']; // 4 planets for grade 9
            sections.forEach(function(section) {
                var option = document.createElement('option');
                option.value = section;
                option.textContent = section;
                sectionDropdown.appendChild(option);
            });
        } else if (grade == '10') {
            var sections = ['Einstein', 'Curie', 'Newton', 'Tesla']; // 4 scientists for grade 10
            sections.forEach(function(section) {
                var option = document.createElement('option');
                option.value = section;
                option.textContent = section;
                sectionDropdown.appendChild(option);
            });
        } else if (grade == '11' || grade == '12') {
            var sections = ['Humss', 'Abm', 'Stem', 'Gas']; // Default 4 sections for grades 11 and 12
            sections.forEach(function(section) {
                var option = document.createElement('option');
                option.value = section;
                option.textContent = section;
                sectionDropdown.appendChild(option);
            });
        }
    });
</script>

<script>
    document.getElementById('lrn').addEventListener('input', function() {
        var lrn = this.value; // Get LRN from the input field

        // Check if there's text in the input field
        if (lrn) {
            var qrImageUrl = "https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl=" + encodeURIComponent(lrn);

            // Display the QR code in the div
            document.getElementById("qr-code").innerHTML = '<img src="' + qrImageUrl + '" alt="QR Code">';
        } else {
            // Clear QR code if LRN is empty
            document.getElementById("qr-code").innerHTML = '';
        }
    });
</script>

<script>
    document.getElementById('lrn').addEventListener('input', function() {
        var lrn = this.value; // Get LRN from the input field
        var sectionDropdown = document.getElementById("qr-code");

        // Clear previous QR code
        sectionDropdown.innerHTML = '';

        // Check if there's text in the input field
        if (lrn) {
            // Generate QR code for the LRN
            var qrCode = new QRCode(sectionDropdown, {
                text: lrn, // The LRN value will be encoded into the QR code
                width: 256, // QR Code width
                height: 256, // QR Code height
                colorDark: "#000000", // Dark color for QR code
                colorLight: "#ffffff", // Light color (background)
                correctLevel: QRCode.CorrectLevel.L // Error correction level
            });
        }
    });
</script>




<?php

include_once "footer.php";

?>