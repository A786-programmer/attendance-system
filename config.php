<?php 
    $con = mysqli_connect('localhost','root','','attendance_system');
    session_start();
    $currentDate = date('Y-m-d');
    $currentTime = date("H:i");
    $currentDateTime = date('Y-m-d h:i:s');  
    date_default_timezone_set('Asia/Karachi');
    // date_default_timezone_set("Canada/Central");
    error_reporting(0);
    $websiteName = 'Attendance System';
    $ipAddress = $_SERVER['REMOTE_ADDR'];

    $user = mysqli_query($con,"SELECT * FROM users WHERE u_id = '$_SESSION[as_user]'");
    $fetchUser = mysqli_fetch_array($user);
    $role = $fetchUser['u_role'];
    $profileImg = 'logo.png';
    $hasAdminRights = $fetchUser['u_role'] == 'Admin' ? true : false;
    if ($fetchUser['u_profile_img']) {
        $profileImg = $fetchUser['u_profile_img'];
    }
?>
<?php

// foreach($usersFileData as $row){
//     $elements = explode(',', $row);
//     if($elements[0] == $_SESSION['userId']){
//         $currentUser = $elements;
//     }
// }

// $img = 'userProfiles/'.$currentUser[4];
// if($currentUser[4] == ''){
//     $img = 'assets/img/profiles/avator1.jpg';
// }
// if($currentUser[5] == 0){
//     $role = 'Admin';
// }
// elseif($currentUser[5] == 1){
//     $role = 'User';
// }

// $dayName = date("l");
// $standardClockIn = $mondayClockIn;
// $standardClockOut = $mondayClockOut;

// switch($dayName){
//     case 'Monday':
//         $standardClockIn = $mondayClockIn;
//         $standardClockOut = $mondayClockOut;
//     break;
//     case 'Tuesday':
//         $standardClockIn = $tuesdayClockIn;
//         $standardClockOut = $tuesdayClockOut;
//     break;
//     case 'Wednesday':
//         $standardClockIn = $wednesdayClockIn;
//         $standardClockOut = $wednesdayClockOut;
//     break;
//     case 'Thursday':
//         $standardClockIn = $thursdayClockIn;
//         $standardClockOut = $thursdayClockOut;
//     break;
//     case 'Friday':
//         $standardClockIn = $fridayClockIn;
//         $standardClockOut = $fridayClockOut;
//     break;
//     case 'Saturday':
//         $standardClockIn = $saturdayClockIn;
//         $standardClockOut = $saturdayClockOut;
//     break;
//     case 'Sunday':
//         $standardClockIn = $sundayClockIn;
//         $standardClockOut = $sundayClockOut;
//     break;
//     default:
//         $standardClockIn = $mondayClockIn;
//         $standardClockOut = $mondayClockOut;
// }

// $ipAddress = $_SERVER['REMOTE_ADDR'];
?>