<?php
include_once 'connectdb.php';
session_start();

if ($_SESSION['username'] == "") {
    header('location:../login.php');
}

include_once "header.php";

// Handle filter input and clear
if (isset($_POST['clear_filter'])) {
    $selected_grade = '';
    $selected_section = '';
} else {
    $selected_grade = isset($_POST['select_grade']) ? $_POST['select_grade'] : '';
    $selected_section = isset($_POST['select_section']) ? $_POST['select_section'] : '';
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Students</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="m-0">Students</h5>
                        </div>

                        <!-- Filter Form -->
                        <form method="POST" action="" class="form-inline p-3">
                            <div class="form-group mr-3">
                                <label for="grade" class="mr-2">Grade</label>
                                <select class="form-control" name="select_grade" id="grade" required>
                                    <option value="" disabled selected>Select Grade</option>
                                    <?php
                                    $grades = ['7', '8', '9', '10', '11', '12'];
                                    foreach ($grades as $grade) {
                                        $selected = ($grade == $selected_grade) ? 'selected' : '';
                                        echo "<option value=\"$grade\" $selected>$grade</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group mr-3">
                                <label for="section" class="mr-2">Section/Strand</label>
                                <select class="form-control" name="select_section" id="section" required>
                                    <option value="" disabled selected>Select Section</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary mr-2">Filter</button>
                            <!-- Change this button to a normal button and use JS for redirect -->
                            <button type="button" class="btn btn-secondary" id="resetButton">Reset</button>
                        </form>

                        <!-- Student Table -->
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <td>#</td>
                                    <td>Name</td>
                                    <td>Lrn</td>
                                    <!-- <td>Password</td> -->
                                    <td>Grade</td>
                                    <td>Section No.</td>
                                    <td>Guardian's Name</td>
                                    <td>Address</td>
                                    <td>Guardian's Contact</td>
                                    <td>QR</td>
                                    <td>Actions</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // If filters are applied, use them in the query
                                if ($selected_grade && $selected_section) {
                                    $select = $pdo->prepare('SELECT * FROM tbl_student WHERE grade = :grade AND section = :section ORDER BY id ASC');
                                    $select->bindParam(':grade', $selected_grade);
                                    $select->bindParam(':section', $selected_section);
                                } else {
                                    // If no filters, show all students
                                    $select = $pdo->prepare('SELECT * FROM tbl_student ORDER BY id ASC');
                                }

                                $select->execute();

                                while ($row = $select->fetch(PDO::FETCH_OBJ)) {
                                    echo '
                                    <tr>
                                        <td>' . $row->id . '</td>
                                        <td>' . $row->name . '</td>
                                        <td>' . $row->lrn . '</td>
                                        
                                        <td>' . $row->grade . '</td>
                                        <td>' . $row->section . '</td>
                                        <td>' . $row->gname . '</td>
                                        <td>' . $row->address . '</td>
                                        <td>' . $row->gcontact . '</td>
                                        <td><img src="' . $row->image . '" class="img-rounded" width="40px" height="40px"></td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="viewstudent.php?id=' . $row->id . '" class="btn btn-warning btn-xs" role="button">
                                                    <span class="fa fa-eye" style="color:#ffffff" data-toggle="tooltip" title="View Student"></span>
                                                </a>
                                                <button id="' . $row->id . '" class="btn btn-danger btn-xs btndelete">
                                                    <span class="fa fa-trash" style="color:#ffffff" data-toggle="tooltip" title="Remove Student"></span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Grade to Section Dropdown Script -->
<script>
    document.getElementById('grade').addEventListener('change', function() {
        var grade = this.value;
        var sectionDropdown = document.getElementById('section');
        sectionDropdown.innerHTML = '<option value="" disabled selected>Select Section</option>';

        var sections = [];

        if (grade === '7') sections = ['Rose', 'Tulip', 'Lily', 'Daisy'];
        else if (grade === '8') sections = ['Ruby', 'Emerald', 'Sapphire', 'Diamond'];
        else if (grade === '9') sections = ['Mercury', 'Venus', 'Earth', 'Mars'];
        else if (grade === '10') sections = ['Einstein', 'Curie', 'Newton', 'Tesla'];
        else if (grade === '11' || grade === '12') sections = ['Humss', 'Abm', 'Stem', 'Gas'];

        sections.forEach(function(section) {
            var option = document.createElement('option');
            option.value = section;
            option.textContent = section;
            sectionDropdown.appendChild(option);
        });
    });

    // Redirect to students.php when the Reset button is clicked
    document.getElementById('resetButton').addEventListener('click', function() {
        window.location.href = 'students.php'; // Redirect to the students page
    });

    // Re-select section after reload (after applying the grade filter)
    window.addEventListener('DOMContentLoaded', function() {
        var selectedGrade = "<?php echo $selected_grade; ?>";
        var selectedSection = "<?php echo $selected_section; ?>";

        if (selectedGrade !== "") {
            document.getElementById('grade').value = selectedGrade;
            var event = new Event('change');
            document.getElementById('grade').dispatchEvent(event);

            setTimeout(function() {
                document.getElementById('section').value = selectedSection;
            }, 100);
        }
    });
</script>

<!-- Delete Script -->
<script>
    $(document).ready(function() {
        $('.btndelete').click(function() {
            var tdh = $(this);
            var id = $(this).attr("id");

            Swal.fire({
                title: "Do you want to delete it?",
                text: "You won’t be able to undo this action.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'studentdelete.php',
                        type: 'post',
                        data: {
                            id: id
                        },
                        success: function(data) {
                            tdh.parents('tr').hide();
                            Swal.fire("Deleted!", "Student Deleted Successfully", "success");
                        }
                    });
                }
            });
        });
    });
</script>

<?php include_once "footer.php"; ?>