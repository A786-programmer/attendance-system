<?php
include 'config.php';
$type = $_GET['type'];

switch($type){
    case 'logout':
        session_destroy();
        echo '<script>window.location="login.php";</script>';
    break;
    case 'deleteUser':
        $userId = $_GET['userId'];
        try {
            mysqli_query($con,"DELETE FROM `users` WHERE u_id='$userId'");
            $_SESSION['toastr_message'] = "User Has been Deleted Successfully!";
            $_SESSION['toastr_type'] = "success";
            header("Location: users.php");
            exit();
        } catch (Exception $e) {
            $_SESSION['toastr_message'] = "Something went wrong: " . $e->getMessage();
            $_SESSION['toastr_type'] = "error";
            header("Location: users.php");
            exit();
        }
    break;
    case 'deactivateUser':
        $userId = $_GET['userId'];
        try {
            mysqli_query($con,"UPDATE `users` SET u_status = '0' WHERE u_id='$userId'");
            $_SESSION['toastr_message'] = "User Has been Deactived Successfully!";
            $_SESSION['toastr_type'] = "success";
            header("Location: users.php");
            exit();
        } catch (Exception $e) {
            $_SESSION['toastr_message'] = "Something went wrong: " . $e->getMessage();
            $_SESSION['toastr_type'] = "error";
            header("Location: users.php");
            exit();
        }
    break;
    case 'activateUser':
        $userId = $_GET['userId'];
        try {
            mysqli_query($con,"UPDATE `users` SET u_status = '1' WHERE u_id='$userId'");
            $_SESSION['toastr_message'] = "User Has been Activated Successfully!";
            $_SESSION['toastr_type'] = "success";
            header("Location: users.php");
            exit();
        } catch (Exception $e) {
            $_SESSION['toastr_message'] = "Something went wrong: " . $e->getMessage();
            $_SESSION['toastr_type'] = "error";
            header("Location: users.php");
            exit();
        }
    break;
    case 'moveToNoticePeriod':
        $userId = $_GET['userId'];
        try {
            mysqli_query($con,"UPDATE `users` SET u_job_type = 'Notice Period' WHERE u_id='$userId'");
            $_SESSION['toastr_message'] = "User Has been Shifted to Notice Period Successfully!";
            $_SESSION['toastr_type'] = "success";
            header("Location: users.php");
            exit();
        } catch (Exception $e) {
            $_SESSION['toastr_message'] = "Something went wrong: " . $e->getMessage();
            $_SESSION['toastr_type'] = "error";
            header("Location: users.php");
            exit();
        }
    break;
    case 'moveToPermanent':
        $userId = $_GET['userId'];
        try {
            mysqli_query($con,"UPDATE `users` SET u_job_type = 'Permanent' WHERE u_id='$userId'");
            $_SESSION['toastr_message'] = "User Has been Promoted to Permanent Position Successfully!";
            $_SESSION['toastr_type'] = "success";
            header("Location: users.php");
            exit();
        } catch (Exception $e) {
            $_SESSION['toastr_message'] = "Something went wrong: " . $e->getMessage();
            $_SESSION['toastr_type'] = "error";
            header("Location: users.php");
            exit();
        }
    break;
    case 'deleteIpAddress':
        $ipAddressId = $_GET['ipAddressId'];
        try {
            mysqli_query($con,"DELETE FROM `ip_addresses` WHERE ia_id='$ipAddressId'");
            $_SESSION['toastr_message'] = "IpAddress Has been Deleted Successfully!";
            $_SESSION['toastr_type'] = "success";
            header("Location: index.php");
            exit();
        } catch (Exception $e) {
            $_SESSION['toastr_message'] = "Something went wrong: " . $e->getMessage();
            $_SESSION['toastr_type'] = "error";
            header("Location: index.php");
            exit();
        }
    break;
    case 'deleteAttendance':
        $attenadanceId = $_GET['attenadanceId'];
        try {
            mysqli_query($con,"DELETE FROM `attendance` WHERE a_id='$attenadanceId'");
            $_SESSION['toastr_message'] = "Attendance Has been Deleted Successfully!";
            $_SESSION['toastr_type'] = "success";
            header("Location: attendance.php");
            exit();
        } catch (Exception $e) {
            $_SESSION['toastr_message'] = "Something went wrong: " . $e->getMessage();
            $_SESSION['toastr_type'] = "error";
            header("Location: attendance.php");
            exit();
        }
    break;
    // case 'updateIP':
    //     $ipAddress1 = $_GET['ipAddress1'];
    //     $ipAddress2 = $_GET['ipAddress2'];
    //     $finalUpdatedString = $ipAddress1.';'.$ipAddress2;
    //     $file = fopen($ipAddressFileName, 'w');
    //     if (fwrite($file, $finalUpdatedString)) {
    //         echo 1;
    //     } 
    //     else {
    //         echo 0;
    //     }
    // break;
    // case 'attendanceDelete':
    //     $attendanceId = $_GET['attendanceId'];
    //     $finalUpdatedString = '';
    //     foreach($attendanceFileData as $row){
    //         $elements = explode(',', $row);
    //         if($attendanceId == $elements[0]){
    //             continue;
    //         }
    //         $finalUpdatedString .= $row.';';
    //     }
    //     $finalUpdatedString = trim($finalUpdatedString, ';');
    //     $file = fopen($attendanceFileName, 'w');
    //     if (fwrite($file, $finalUpdatedString)) {
    //         echo'<script>alert("Record Deleted!");
    //         window.location="attendance.php";</script>';
    //     } 
    //     else {
    //         echo'<script>alert("Server Error!");
    //         window.location="attendance.php";</script>';
    //     }
    // break;
    // case 'adminDelete':
    //     $adminId = $_GET['adminId'];
    //     $finalUpdatedString = '';
    //     foreach($usersFileData as $row){
    //         $elements = explode(',', $row);
    //         if($adminId == $elements[0]){
    //             continue;
    //         }
    //         $finalUpdatedString .= $row.';';
    //     }
    //     $finalUpdatedString = trim($finalUpdatedString, ';');
    //     $file = fopen($usersFileName, 'w');
    //     if (fwrite($file, $finalUpdatedString)) {
    //         echo'<script>alert("Admin Deleted!");
    //         window.location="admins.php";</script>';
    //     } 
    //     else {
    //         echo'<script>alert("Server Error!");
    //         window.location="admins.php";</script>';
    //     }
    // break;
    // case 'updateTime':
    //     $mondayClockIn = $_GET['mondayClockIn'];
    //     $mondayClockOut = $_GET['mondayClockOut'];
    //     $tuesdayClockIn = $_GET['tuesdayClockIn'];
    //     $tuesdayClockOut = $_GET['tuesdayClockOut'];
    //     $wednesdayClockIn = $_GET['wednesdayClockIn'];
    //     $wednesdayClockOut = $_GET['wednesdayClockOut'];
    //     $thursdayClockIn = $_GET['thursdayClockIn'];
    //     $thursdayClockOut = $_GET['thursdayClockOut'];
    //     $fridayClockIn = $_GET['fridayClockIn'];
    //     $fridayClockOut = $_GET['fridayClockOut'];
    //     $saturdayClockIn = $_GET['saturdayClockIn'];
    //     $saturdayClockOut = $_GET['saturdayClockOut'];
    //     $sundayClockIn = $_GET['sundayClockIn'];
    //     $sundayClockOut = $_GET['sundayClockOut'];
    //     $finalUpdatedString = $mondayClockIn.','.$mondayClockOut.','.$tuesdayClockIn.','.$tuesdayClockOut.','.$wednesdayClockIn.','.$wednesdayClockOut.','.$thursdayClockIn.','.$thursdayClockOut.','.$fridayClockIn.','.$fridayClockOut.','.$saturdayClockIn.','.$saturdayClockOut.','.$sundayClockIn.','.$sundayClockOut; 
    //     $file = fopen($appSettingsFileName, 'w');
    //     if (fwrite($file, $finalUpdatedString)) {
    //         echo 1;
    //     } 
    //     else {
    //         echo 0;
    //     }
    // break;
    // case 'addClockIn':
    //     $newId = 0;
    //     foreach($attendanceFileData as $row){
    //         $elements = explode(',', $row);
    //         $newId = $elements[0];
    //     }
    //     $newId++;
    //     if($currentTime <= $standardClockOut){
    //         $data = ';'.$newId.','.$currentDate.','.$currentTime.','.$standardClockOut.',0,'.$_SESSION['userId'];
    //         $file = fopen($attendanceFileName, 'a');
    //         if ($file) {
    //             if (fwrite($file, $data) !== false) {
    //                 echo 1;
    //                 fclose($file); 
    //             } 
    //             else {
    //                 echo 0;
    //             }
    //         } 
    //         else {
    //             echo 3;
    //         }
    //     }
    //     else{
    //         echo 2;
    //     }
    // break;
    // case 'addClockOut':
    //     foreach($attendanceFileData as $row){
    //         $elements = explode(',', $row);
    //         $row = $elements[0].','.$elements[1].','.$elements[2].','.$elements[3].','.$elements[4].','.$elements[5].';';
    //         if($elements[5] == $_SESSION['userId'] && $elements[1] == $currentDate){
    //             $row = $elements[0].','.$elements[1].','.$elements[2].','.$currentTime.',1,'.$elements[5].';';
    //             $updated = true;
    //         }
    //         $finalAttendanceString .= $row;
    //     }
    //     $finalAttendanceString = trim($finalAttendanceString, ';');

    //     if ($updated) {
    //         $file = fopen($attendanceFileName, 'w');
    //         if (fwrite($file, $finalAttendanceString)) {
    //             echo 1;
    //         } 
    //         else {
    //             echo 0;
    //         }
    //     } 
    //     else {
    //         echo 2;
    //     }
    // break;
    // case 'getRecord':
    //     function sum_the_time($time1, $time2) {
    //         $times = array($time1, $time2);
    //         $seconds = 0;
    //         foreach ($times as $time){
    //             list($hour,$minute,$second) = explode(':', $time);
    //             $seconds += $hour*3600;
    //             $seconds += $minute*60;
    //             $seconds += $second;
    //         }
    //         $hours = floor($seconds/3600);
    //         $seconds -= $hours*3600;
    //         $minutes  = floor($seconds/60);
    //         $seconds -= $minutes*60;
    //         if($seconds < 9){
    //             $seconds = "0".$seconds;
    //         }
    //         if($minutes < 9){
    //             $minutes = "0".$minutes;
    //         }
    //         if($hours < 9){
    //             $hours = "0".$hours;
    //         }
    //         return "{$hours}:{$minutes}";
    //     }
    //     // $userId = $_GET['userId'];
    //     $startDate = $_GET['startDate'];
    //     $endDate = $_GET['endDate'];
    //     foreach($usersFileData as $row){
    //         $elements = explode(',', $row);
    //         if($elements[5] == 1){
    //             foreach($attendanceFileData as $row1){
    //                 $elements1 = explode(',', $row1);
    //                 if($elements1[1] >= $startDate && $elements1[1] <= $endDate && $elements1[5] == $elements[0]){
    //                     $fetchedRecordString .= $elements1[1].','.$elements1[2].','.$elements1[3].';';
    //                 }
    //             }
    //             $fetchedRecordString .= '0,0,'.$elements[1].';';
    //         }
    //     }
    //     $total = '00:00';
    //     $sno = 1;
    //     $string = '';        
    //     $fetchedRecordString = trim($fetchedRecordString, ';');
    //     $fetchedRecordArray = explode(";", $fetchedRecordString);
    //     for($i = count($fetchedRecordArray)-1; $i >= 0; $i--){
    //         $elements2 = explode(',', $fetchedRecordArray[$i]);
    //         if($elements2[0] == 0 && $elements2[1] == 0){
    //             if($i == count($fetchedRecordArray)-1) {
    //                 $nameString = '<tr><td colspan="3"></td><td><h5>'.$elements2[2].'</h5></td><td>';
    //             }
    //             else {
    //                 $nameString .= $total.'</td></tr>';
    //                 $string .= $nameString;
    //                 $nameString = '<tr><td colspan="3"></td><td><h5>'.$elements2[2].'</h5></td><td>';
    //                 $total = '00:00';
    //                 $sno = 1;
    //             }
    //         }
    //         else{
    //             $a = new DateTime($elements2[1]);
    //             $b = new DateTime($elements2[2]);
    //             $interval = $a->diff($b);
    //             $hoursWorked = $interval->format("%H:%i");
    //             $total = sum_the_time($total, $hoursWorked);
    //             $string .= '<tr><td>'.$sno.'</td><td>'.$elements2[0].'</td>
    //             <td>'.$elements2[1].'</td><td>'.$elements2[2].'</td><td>'.$hoursWorked.'</td></tr>';
    //             $sno++;
    //         }
    //     }
    //     $string .= $nameString;
    //     $string .= $total.'</td></tr>';
    //     // 0,0,Mustafa;
    //     // 2023-11-06,11:03,18:03;
    //     // 2023-11-04,12:36,18:37;
    //     // 0,0,Alia;
    //     // 2023-11-06,09:02,21:03;
    //     // <tr><td>1</td><td>2023-11-06</td><td>11:03</td><td>18:03</td><td>07:0</td></tr>
    //     // <tr><td>2</td><td>2023-11-04</td><td>12:36</td><td>18:37</td><td>06:1</td></tr>
    //     // 13:01</td></tr>
    //     // <tr><td>1</td><td>2023-11-06</td><td>09:02</td><td>21:03</td><td>12:1</td></tr>
    //     echo $string;
    // break;
    // case 'getRecord':
    //     function sum_the_time($time1, $time2) {
    //         $times = array($time1, $time2);
    //         $seconds = 0;
    //         foreach ($times as $time){
    //             list($hour,$minute,$second) = explode(':', $time);
    //             $seconds += $hour*3600;
    //             $seconds += $minute*60;
    //             $seconds += $second;
    //         }
    //         $hours = floor($seconds/3600);
    //         $seconds -= $hours*3600;
    //         $minutes  = floo{r($seconds/60);
    //         $seconds -= $minutes*60;
    //         if($seconds < 9){
    //             $seconds = "0".$seconds;
    //         }
    //         if($minutes < 9){
    //             $minutes = "0".$minutes;
    //         }
    //         if($hours < 9){
    //             $hours = "0".$hours;
    //         }
    //         return "{$hours}:{$minutes}";
    //     }
    //     // $userId = $_GET['userId'];
    //     $startDate = $_GET['startDate'];
    //     $endDate = $_GET['endDate'];
    //     $total = '00:00:00';
    //     $totalForUser = '00:00:00';
    //     $sno = 1;
    //     $string = '';
    //     $fetchedRecordString = '';
    //     foreach($attendanceFileData as $row){
    //         $elements = explode(',', $row);
    //         $userName = '';
    //         if($elements[1] >= $startDate && $elements[1] <= $endDate){
    //             foreach($usersFileData as $row1){
    //                 $elements1 = explode(',', $row1);
    //                 if($elements1[0] == $elements[5]){
    //                     $userName = $elements1[1];
    //                     break;
    //                 }
    //             }
    //             $fetchedRecordString .= $userName.','.$elements[1].','.$elements[2].','.$elements[3].';';
    //         }
    //     }
    //     $fetchedRecordString = trim($fetchedRecordString, ';');
    //     $fetchedRecordArray = explode(";", $fetchedRecordString);
    //     foreach($fetchedRecordArray as $row){
    //         $elements = explode(',', $row);
    //         $a = new DateTime($elements[1]);
    //         $b = new DateTime($elements[2]);
    //         $interval = $a->diff($b);
    //         $hoursWorked = $interval->format("%H:%i");
    //         $total = sum_the_time($total, $hoursWorked);
    //         $string .= '<tr><td>'.$sno.'</td><td>'.$elements[0].'</td><td>'.$elements[1].'</td><td>'.$elements[2].'</td><td>'.$elements[3].'</td><td>'.$hoursWorked.'</td></tr>';
    //         $sno++;
    //     }
    //     $string .= '<tr><td colspan="5">Total Hours</td><td>'.$total.'</td></tr>';
    //     echo $string;
    // break;
    default:
        echo '<script>alert("Invalid Access");
        window.location="index.php";</script>';
}
?>