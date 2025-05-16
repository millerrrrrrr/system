<?php
session_start();
include_once "header.php";
include_once "connectdb.php";
include_once "phpqrcode/qrlib.php";  // QR Code library

define('QR_DIRECTORY', 'studentsqr/');
$qrCodeFileName = '';
$showModal = false;

if (isset($_POST['btn_save'])) {
    $name = $_POST['name'];
    $lrn = $_POST['lrn'];
    $password = "123";
    $grade = $_POST['select_grade'];
    $section = $_POST['select_section'];
    $gname = $_POST['guardian_name'];
    $address = $_POST['address'];
    $gcontact = $_POST['guardian_contact'];

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

    $studentJson = json_encode($studentInfo);
    $qrCodeFileName = QR_DIRECTORY . $lrn . '_' . time() . '.png';
    QRcode::png($studentJson, $qrCodeFileName);

    $selectLrn = $pdo->prepare("SELECT lrn FROM tbl_student WHERE lrn = :lrn");
    $selectName = $pdo->prepare("SELECT name FROM tbl_student WHERE name = :name");

    $selectLrn->execute([':lrn' => $lrn]);
    $selectName->execute([':name' => $name]);

    if ($selectLrn->rowCount() > 0 || $selectName->rowCount() > 0) {
        $_SESSION['status'] = $selectLrn->rowCount() > 0 ? "LRN already exists." : "Name already exists.";
        $_SESSION['status_code'] = 'warning';
    } else {
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
        $insert->bindParam(':image', $qrCodeFileName);

        if ($insert->execute()) {
            $showModal = true;
            $_SESSION['qr_code_path'] = $qrCodeFileName;
        } else {
            $_SESSION['status'] = "Error saving student.";
            $_SESSION['status_code'] = 'error';
        }
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
    }
</style>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0">Registration</h1>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h5 class="m-0">Registration Form</h5>
                </div>
                <div class="card-body">
                    <form action="" method="POST" id="registrationForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" placeholder="Enter Name" name="name" required>
                                </div>

                                <div class="form-group">
                                    <label>LRN</label>
                                    <input type="number" class="form-control" name="lrn" placeholder="Enter LRN" required>
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
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Guardian's Name</label>
                                    <input type="text" class="form-control" name="guardian_name" placeholder="Enter Guardian's Name" required>
                                </div>

                                <div class="form-group">
                                    <label>Address</label>
                                    <input type="text" class="form-control" name="address" placeholder="Enter Address" required>
                                </div>

                                <div class="form-group">
                                    <label>Guardian's Contact No.</label>
                                    <input type="number" class="form-control" name="guardian_contact" placeholder="Enter Contact No." required>
                                </div>
                            </div>

                            <div class="col-md-12 text-right">
                                <button type="submit" class="btn btn-primary" name="btn_save">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- QR Modal -->
<div class="modal fade" id="qrModal" tabindex="-1" role="dialog" aria-labelledby="qrModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Student QR Code</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('#qrModal').modal('hide');">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <?php if (!empty($qrCodeFileName)) : ?>
                    <img src="<?php echo $qrCodeFileName; ?>" id="qrImage" class="img-fluid mb-3" alt="QR Code">
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <?php if (!empty($qrCodeFileName)) : ?>
                    <a href="<?php echo $qrCodeFileName; ?>" download class="btn btn-primary">Download QR</a>
                <?php endif; ?>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('grade').addEventListener('change', function() {
        var grade = this.value;
        var sectionDropdown = document.getElementById('section');
        sectionDropdown.innerHTML = '<option value="" disabled selected>Select Section</option>';

        let sections = [];
        if (grade == '7') sections = ['Rose', 'Tulip', 'Lily', 'Daisy'];
        else if (grade == '8') sections = ['Ruby', 'Emerald', 'Sapphire', 'Diamond'];
        else if (grade == '9') sections = ['Mercury', 'Venus', 'Earth', 'Mars'];
        else if (grade == '10') sections = ['Einstein', 'Curie', 'Newton', 'Tesla'];
        else if (grade == '11' || grade == '12') sections = ['Humss', 'Abm', 'Stem', 'Gas'];

        sections.forEach(function(section) {
            var option = document.createElement('option');
            option.value = section;
            option.textContent = section;
            sectionDropdown.appendChild(option);
        });
    });

    <?php if ($showModal): ?>
        window.onload = function() {
            $('#qrModal').modal('show');
            document.getElementById('registrationForm').reset();
        };
    <?php endif; ?>
</script>

<!-- Bootstrap and jQuery if not already loaded -
<?php include_once "footer.php"; ?>