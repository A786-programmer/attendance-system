<?php 
    $con = mysqli_connect('localhost','root','','attendance_system');
    session_start();
    $currentDate = date('Y-m-d');
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
    $yourIP = $_SERVER['REMOTE_ADDR'];

    $ipArray = [];
    $ips = mysqli_query($con, "SELECT ia_address FROM `ip_addresses`");
    while ($fetchIPs = mysqli_fetch_assoc($ips)) {
        $ipArray[] = $fetchIPs['ia_address'];
    }
?>