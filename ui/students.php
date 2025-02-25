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
                    <h1 class="m-0">Students</h1>
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
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="m-0">Students</h5>
                        </div>
                        <!-- Add the dropdowns for grade and section above the table -->
                        <form method="POST" action="" class="form-inline">
                            <div class="form-group mr-3">
                                <label for="grade" class="mr-2">Grade</label>
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

                            <div class="form-group mr-3">
                                <label for="section" class="mr-2">Section/Strand</label>
                                <select class="form-control" name="select_section" id="section" required>
                                    <option value="" disabled selected>Select Section</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Filter</button>
                        </form>


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
                                // Here you can filter students based on grade and section if needed.
                                // For now, I am just listing all the students.

                                // Example: 
                                // $select = $pdo->prepare('SELECT * from tbl_user ORDER BY userid ASC');
                                // $select->execute();

                                // while ($row = $select->fetch(PDO::FETCH_OBJ)) {
                                //     echo '
                                //         <tr>
                                //         <td>' . $row->userid . '</td>
                                //         <td>' . $row->username . '</td>
                                //         <td>' . $row->userage . '</td>
                                //         <td>' . $row->useremail . '</td>
                                //         <td>' . $row->useraddress . '</td>
                                //         <td>' . $row->usercontact . '</td>
                                //         <td>' . $row->userpassword . '</td>
                                //         <td>' . $row->role . '</td>
                                //         <td>
                                //         <a href="#" class="btn btn-danger" onclick="confirmDelete(' . $row->userid . ');"><i class="fa fa-trash-alt"></i></a>
                                //         </td>
                                //         </tr>
                                //     ';
                                // }
                                ?>
                            </tbody>
                        </table>
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

<script>
    document.getElementById('grade').addEventListener('change', function() {
        var grade = this.value; // Get the selected grade
        var sectionDropdown = document.getElementById('section'); // Get the section dropdown

        // Clear previous options in the section dropdown
        sectionDropdown.innerHTML = '<option value="" disabled selected>Select Section</option>';

        // Based on grade, add the relevant options to the section dropdown
        if (grade == '7') {
            var sections = ['Rose', 'Tulip', 'Lily', 'Daisy']; // 4 flowers for grade 7
        } else if (grade == '8') {
            var sections = ['Ruby', 'Emerald', 'Sapphire', 'Diamond']; // 4 gems for grade 8
        } else if (grade == '9') {
            var sections = ['Mercury', 'Venus', 'Earth', 'Mars']; // 4 planets for grade 9
        } else if (grade == '10') {
            var sections = ['Einstein', 'Curie', 'Newton', 'Tesla']; // 4 scientists for grade 10
        } else if (grade == '11' || grade == '12') {
            var sections = ['Humss', 'Abm', 'Stem', 'Gas']; // Default 4 sections for grades 11 and 12
        }

        // Create and append options for the section dropdown
        sections.forEach(function(section) {
            var option = document.createElement('option');
            option.value = section;
            option.textContent = section;
            sectionDropdown.appendChild(option);
        });
    });
</script>

<?php
include_once "footer.php";
?>