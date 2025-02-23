<?php
session_start();
include_once "header.php";


?>

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
                                        <input type="text" class="form-control" placeholder="Enter Name" name="name">
                                    </div>

                                    <div class="form-group">
                                        <label>Lrn</label>
                                        <input type="number" class="form-control" placeholder="Enter Lrn" name="lrn">
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

                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" class="form-control" placeholder="Password" name="password" required>
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
                                    $select = $pdo->prepare('SELECT * from tbl_user ORDER BY userid ASC');
                                    $select->execute();

                                    while ($row = $select->fetch(PDO::FETCH_OBJ)) {
                                        echo '
                                        <tr>
                                        <td>' . $row->userid . '</td>
                                        <td>' . $row->username . '</td>
                                        <td>' . $row->userage . '</td>
                                        <td>' . $row->useremail . '</td>
                                        <td>' . $row->useraddress . '</td>
                                        <td>' . $row->usercontact . '</td>
                                        <td>' . $row->userpassword . '</td>
                                        <td>' . $row->role . '</td>
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





<script>
    document.getElementById('grade').addEventListener('change', function() {
        var grade = this.value;
        var sectionDropdown = document.getElementById('section');

        // Clear previous options
        sectionDropdown.innerHTML = '<option value="" disabled selected>Select Section</option>';

        // Based on grade, add the relevant options to the section dropdown
        if (grade == '7' || grade == '8' || grade == '9' || grade == '10') {
            var sections = ['A', 'B', 'C', 'D', 'E', 'F'];
            sections.forEach(function(section) {
                var option = document.createElement('option');
                option.value = section;
                option.textContent = section;
                sectionDropdown.appendChild(option);
            });
        } else if (grade == '11' || grade == '12') {
            var strands = ['STEM', 'ABM', 'HUMSS', 'GAS'];
            strands.forEach(function(strand) {
                var option = document.createElement('option');
                option.value = strand;
                option.textContent = strand;
                sectionDropdown.appendChild(option);
            });
        }
    });
</script>




<?php

include_once "footer.php";

?>