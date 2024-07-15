<?php
include("../conn/conn.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['student_name'], $_POST['student_course'])) {
        $studentName = $_POST['student_name'];
        $studentCourse = $_POST['student_course'];
        $timeIn = date("H:i:s"); 

        try {
            $stmt = $conn->prepare("INSERT INTO tbl_student (student_name, student_course, time_in) VALUES (:student_name, :student_course, :time_in)");
            
            $stmt->bindParam(":student_name", $studentName, PDO::PARAM_STR); 
            $stmt->bindParam(":student_course", $studentCourse, PDO::PARAM_STR);
            $stmt->bindParam(":time_in", $timeIn, PDO::PARAM_STR);

            $stmt->execute();

            header("Location: http://localhost/event-student-attendance/");

            exit();
        } catch (PDOException $e) {
            echo "Error:" . $e->getMessage();
        }

    } else {
        echo "
            <script>
                alert('Please fill in all fields!');
                window.location.href = 'http://localhost/event-student-attendance/';
            </script>
        ";
    }
}
?>
