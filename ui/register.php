<?php
session_start();
include_once "header.php";
include_once "connectdb.php";

// Include the QR Code library
include_once "phpqrcode/qrlib.php";  // Path to the PHP QR Code library

// Directory to store QR codes
define('QR_DIRECTORY', 'studentsqr/');

// Initialize QR code filename variable
$qrCodeFileName = ''; // Ensure it exists to avoid warning

if (isset($_POST['btn_save'])) {
    // Get the submitted form data
    $name = $_POST['name'];
    $lrn = $_POST['lrn'];
    $password = $_POST['password'];
    $grade = $_POST['select_grade'];
    $section = $_POST['select_section'];
    $gname = $_POST['guardian_name'];
    $address = $_POST['address'];
    $gcontact = $_POST['guardian_contact'];

    // Prepare an associative array of the student details
    $studentInfo = [
        'name' => $name,
        'lrn' => $lrn,
        'password' => $password,
        'grade' => $grade,
        'section' => $section,
        'guardian_name' => $gname,
        'address' => $address,
        'guardian_contact' => $gcontact
    ];

    // Encode the student details to JSON
    $studentJson = json_encode($studentInfo);

    // Generate QR Code based on JSON string, use LRN + timestamp for uniqueness
    $qrCodeFileName = QR_DIRECTORY . $lrn . '_' . time() . '.png'; // Timestamp added for uniqueness
    QRcode::png($studentJson, $qrCodeFileName);  // Generate QR code using the JSON data

    if (isset($lrn) && isset($name)) {
        // Check if LRN or Name already exists
        $selectLrn = $pdo->prepare("SELECT lrn FROM tbl_student WHERE lrn = :lrn");
        $selectName = $pdo->prepare("SELECT name FROM tbl_student WHERE name = :name");

        $selectLrn->execute([':lrn' => $lrn]);
        $selectName->execute([':name' => $name]);

        if ($selectLrn->rowCount() > 0) {
            $statusMessage = "LRN already exists.";
            $statusCode = 'warning';
        } elseif ($selectName->rowCount() > 0) {
            $statusMessage = "Name already exists.";
            $statusCode = 'warning';
        } else {
            // Insert the student into the database, along with the QR code path
            $insert = $pdo->prepare("INSERT INTO tbl_student 
                (name, lrn, password, grade, section, gname, address, gcontact, image)
                VALUES (:name, :lrn, :password, :grade, :section, :gname, :address, :gcontact, :image)");

            $insert->bindParam(':name', $name);
            $insert->bindParam(':lrn', $lrn);
            $insert->bindParam(':password', $password);
            $insert->bindParam(':grade', $grade);
            $insert->bindParam(':section', $section);
            $insert->bindParam(':gname', $gname);
            $insert->bindParam(':address', $address);
            $insert->bindParam(':gcontact', $gcontact);
            $insert->bindParam(':image', $qrCodeFileName);  // Store the QR code file path

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
        -moz-appearance: textfield; /* For Firefox */
    }
</style>

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
                                        <input type="text" class="form-control" placeholder="Enter Name" name="name" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Lrn</label>
                                        <input type="number" class="form-control" id="lrn" placeholder="Enter Lrn" name="lrn" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="text" class="form-control" placeholder="Enter Password" name="password" required>
                                    </div>

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

                                    <div class="form-group">
                                        <label>Guardian's Name</label>
                                        <input type="text" class="form-control" placeholder="Enter Guardian's Name" name="guardian_name" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Address</label>
                                        <input type="text" class="form-control" placeholder="Enter Address" name="address" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Guardian's Contact No.</label>
                                        <input type="number" class="form-control" placeholder="Enter Guardian's Contact No." name="guardian_contact" required>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary" name="btn_save">Save</button>
                                </div>
                            </form>
                        </div>

                        <div class="col-md-6">
                            <label>QR Code</label>
                            <?php
                            // Display the generated QR Code if it exists after form submission
                            if (!empty($qrCodeFileName)) {
                                echo '<img src="' . $qrCodeFileName . '" alt="QR Code">';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('grade').addEventListener('change', function() {
        var grade = this.value;
        var sectionDropdown = document.getElementById('section');

        sectionDropdown.innerHTML = '<option value="" disabled selected>Select Section</option>';

        if (grade == '7') {
            var sections = ['Rose', 'Tulip', 'Lily', 'Daisy'];
            sections.forEach(function(section) {
                var option = document.createElement('option');
                option.value = section;
                option.textContent = section;
                sectionDropdown.appendChild(option);
            });
        } else if (grade == '8') {
            var sections = ['Ruby', 'Emerald', 'Sapphire', 'Diamond'];
            sections.forEach(function(section) {
                var option = document.createElement('option');
                option.value = section;
                option.textContent = section;
                sectionDropdown.appendChild(option);
            });
        } else if (grade == '9') {
            var sections = ['Mercury', 'Venus', 'Earth', 'Mars'];
            sections.forEach(function(section) {
                var option = document.createElement('option');
                option.value = section;
                option.textContent = section;
                sectionDropdown.appendChild(option);
            });
        } else if (grade == '10') {
            var sections = ['Einstein', 'Curie', 'Newton', 'Tesla'];
            sections.forEach(function(section) {
                var option = document.createElement('option');
                option.value = section;
                option.textContent = section;
                sectionDropdown.appendChild(option);
            });
        } else if (grade == '11' || grade == '12') {
            var sections = ['Humss', 'Abm', 'Stem', 'Gas'];
            sections.forEach(function(section) {
                var option = document.createElement('option');
                option.value = section;
                option.textContent = section;
                sectionDropdown.appendChild(option);
            });
        }
    });
</script>

<?php include_once "footer.php"; ?>
