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
            header("Location: add-attendance.php");
            exit();
        } catch (Exception $e) {
            $_SESSION['toastr_message'] = "Something went wrong: " . $e->getMessage();
            $_SESSION['toastr_type'] = "error";
            header("Location: add-attendance.php");
            exit();
        }
    break;
    default:
        echo '<script>alert("Invalid Access");
        window.location="index.php";</script>';
}
?>