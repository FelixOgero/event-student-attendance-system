<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Attendance Sheet System</title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <!-- Data Table -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />

    <!-- Style CSS -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-image: linear-gradient(120deg, #fdfbfb 0%, #ebedee 100%);
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
            overflow: hidden;
        }

        .main {
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
        }

        .alert > h1 {
            width: 100vw;
            margin: 15px !important;
        }

        .attendance-container {
            background-image: linear-gradient(to top, #d6d8d9 0%, #d6d8d9 100%);
            box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
            height: 83%;
            width: 95%;
            padding: 40px;
        }

        .dataTables_wrapper {
            position: relative;
            padding: 10px;
            height: 580px !important;
            text-align: center !important;
        }

        .dataTables_info {
            position: absolute;
            bottom: 10px;
            left: 10px;
        }

        .dataTables_paginate {
            position: absolute;
            bottom: 10px;
            right: 0px;
        }

        table.dataTable thead > tr > th.sorting, table.dataTable thead > tr > th.sorting_asc, table.dataTable thead > tr > th.sorting_desc, table.dataTable thead > tr > th.sorting_asc_disabled, table.dataTable thead > tr > th.sorting_desc_disabled, table.dataTable thead > tr > td.sorting, table.dataTable thead > tr > td.sorting_asc, table.dataTable thead > tr > td.sorting_desc, table.dataTable thead > tr > td.sorting_asc_disabled, table.dataTable thead > tr > td.sorting_desc_disabled {
            text-align: center;
        }

        .action-button {
            display: flex;
            justify-content: center;
        }
        
        .delete-button {
            width: 25px;
            height: 25px;
            font-size: 17px;
            display: flex !important;
            justify-content: center;
            align-items: center;
            margin: 0px 2px;
        }
    </style>

</head>
<body>

    <div class="main">
        <div class="alert alert-dark text-center" role="alert">
            <h1>Event Student Attendance System</h2>
        </div>

        <div class="attendance-container">
            <div class="attendance-header row">
                <h3 class="col-9">Student Attendance</h3>

                <div class="buttons-container">
                    <button class="btn btn-success" onclick="printAttendance()">Print Attendance</button>
                    <button class="btn btn-dark" data-toggle="modal" data-target="#addAttendanceModal">Add Attendance</button>
                </div>
            </div>
            <hr>

            <!-- Add Modal -->
            <div class="modal fade" id="addAttendanceModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="addAttendance" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addAttendance">Add Attendance</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="./endpoint/add-student.php" method="POST">
                                <div class="form-group">
                                    <label for="studentName">Full Name:</label>
                                    <input type="text" class="form-control" id="studentName" name="student_name">
                                </div>
                                <div class="form-group">
                                    <label for="studentCourse">Course and Section:</label>
                                    <input type="text" class="form-control" id="studentCourse" name="student_course">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-dark">Add</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-container table-responsive">
                <table class="table text-center table-sm" id="attendanceTable">
                    <thead class="thead-dark">
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Course & Section</th>
                        <th scope="col">Time In</th>
                        <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php 
                            include ('./conn/conn.php');

                            $stmt = $conn->prepare("SELECT * FROM tbl_student");
                            $stmt->execute();
            
                            $result = $stmt->fetchAll();
            
                            foreach ($result as $row) {
                                $studentID = $row["tbl_student_id"];
                                $studentName = $row["student_name"];
                                $studentCourse = $row["student_course"];
                                $timeIn = $row["time_in"];
                            ?>

                            <tr>
                                <th scope="row"><?= $studentID ?></th>
                                <td><?= $studentName ?></td>
                                <td><?= $studentCourse ?></td>
                                <td><?= $timeIn ?></td>
                                <td>
                                    <div class="action-button">
                                        <button class="btn btn-danger delete-button" onclick="deleteStudent(<?= $studentID ?>)">X</button>
                                    </div>
                                </td>
                            </tr>

                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>

    <!-- Data Table -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>

    <script>
        $(document).ready( function () {
            $('#attendanceTable').DataTable();
        });

        function deleteStudent(id) {
            if (confirm("Do you want to delete this student?")) {
                window.location = "./endpoint/delete-student.php?student=" + id;
            }
        }

        function printAttendance() {
            $('#attendanceTable').find('th:last-child, td:last-child').hide();
            
            document.body.innerHTML = '<div class="text-center mt-3"><img src="https://png.pngtree.com/png-vector/20230306/ourmid/pngtree-scool-college-logo-victor-vector-png-image_6634445.png/" width="190px"><h1 class="mt-2 mb-5">Student Attendance</h1><table class="table" id="print-content">' + document.getElementById('attendanceTable').innerHTML + '</table></div>';
            window.print();
            location.reload();
        }
    </script>
</body>
</html>