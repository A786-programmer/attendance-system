<?php 
include 'config.php';
if (in_array($yourIP, $ipArray)) {
    if ($hasAdminRights) {
        if (isset($_SESSION['as_user'])) {
            $usersActive = 'active';

            $userId = $_GET['userId'] ?? 0;
            $user = mysqli_query($con, "SELECT * FROM `users` WHERE u_id='$userId'");
            if ($userId && mysqli_num_rows($user) == 0) {
                $_SESSION['toastr_message'] = "Invalid Access!";
                $_SESSION['toastr_type'] = "error";
                header("Location: users.php");
                exit();
            }
            $fetchUser = mysqli_fetch_assoc($user);

            // ✅ Fetch emergency contacts
            $contacts = mysqli_query($con, "SELECT * FROM emergency_contacts WHERE ec_user='$userId' ORDER BY ec_id ASC");
            $contact1 = ['ec_id' => 0, 'ec_name' => '', 'ec_relation' => '', 'ec_number' => ''];
            $contact2 = ['ec_id' => 0, 'ec_name' => '', 'ec_relation' => '', 'ec_number' => ''];

            if (mysqli_num_rows($contacts) > 0) {
                $i = 1;
                while ($row = mysqli_fetch_assoc($contacts)) {
                    if ($i == 1) $contact1 = $row;
                    if ($i == 2) $contact2 = $row;
                    $i++;
                }
            }

            // ✅ Add or update contact
            if (isset($_POST['add']) || isset($_POST['update'])) {
                try {
                    $name = $_POST['name'];
                    $relation = $_POST['relation'];
                    $contact = $_POST['contact'];

                    if (isset($_POST['update'])) {
                        $contactId = $_POST['contact_id'];
                        mysqli_query($con, "UPDATE emergency_contacts 
                            SET ec_name='$name', ec_relation='$relation', ec_number='$contact' 
                            WHERE ec_id='$contactId' AND ec_user='$userId'");
                        $_SESSION['toastr_message'] = "Emergency Contact Updated Successfully!";
                    } else {
                        mysqli_query($con, "INSERT INTO emergency_contacts(ec_user, ec_name, ec_relation, ec_number) 
                            VALUES('$userId', '$name', '$relation', '$contact')");
                        $_SESSION['toastr_message'] = "Emergency Contact Added Successfully!";
                    }

                    $_SESSION['toastr_type'] = "success";
                    header("Location: user-details.php?userId=$userId");
                    exit();
                } catch (Exception $e) {
                    $_SESSION['toastr_message'] = "Something went wrong: ".$e->getMessage();
                    $_SESSION['toastr_type'] = "error";
                    header("Location: user-details.php?userId=$userId");
                    exit();
                }
            }

            // ✅ NIC/Bayform Upload
            if (isset($_POST['upload_nic'])) {
                try {
                    if (!is_dir("nic-bayform")) {
                        mkdir("nic-bayform", 0777, true);
                    }

                    $nicFile = $_FILES['nic_file']['name'];
                    if ($nicFile) {
                        $ext = strtolower(pathinfo($nicFile, PATHINFO_EXTENSION));
                        if (in_array($ext, ['pdf', 'png'])) {
                            // delete old file if exists
                            if (!empty($fetchUser['u_nic_bayform']) && file_exists($fetchUser['u_nic_bayform'])) {
                                unlink($fetchUser['u_nic_bayform']);
                            }

                            $newName = 'NIC_' . time() . '_' . $userId . '.' . $ext;
                            $uploadPath = "nic-bayform/" . $newName;
                            move_uploaded_file($_FILES['nic_file']['tmp_name'], $uploadPath);

                            mysqli_query($con, "UPDATE users SET u_nic_bayform='$uploadPath' WHERE u_id='$userId'");
                            $_SESSION['toastr_message'] = "NIC/Bayform uploaded successfully!";
                            $_SESSION['toastr_type'] = "success";
                        } else {
                            $_SESSION['toastr_message'] = "Only PDF or PNG files allowed!";
                            $_SESSION['toastr_type'] = "error";
                        }
                    }

                    header("Location: user-details.php?userId=$userId");
                    exit();
                } catch (Exception $e) {
                    $_SESSION['toastr_message'] = "Error: ".$e->getMessage();
                    $_SESSION['toastr_type'] = "error";
                    header("Location: user-details.php?userId=$userId");
                    exit();
                }
            }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Details</title>
    <?php include 'header-files.php' ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<div class="main-wrapper">
    <?php include 'header.php' ?>
    <?php include 'sidebar.php' ?>

    <div class="page-wrapper">
        <div class="content">

            <div class="page-header">
                <div class="page-title">
                    <h4><?= htmlspecialchars($fetchUser['u_name']); ?> - User Details</h4>
                </div>
            </div>

            <div class="row">
                <!-- Left Column (User Info + NIC Upload) -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body text-center">
                            <?php if (!empty($fetchUser['u_profile_img']) && file_exists("user-profile-imgs/" . $fetchUser['u_profile_img'])) { ?>
                                <img src="user-profile-imgs/<?= htmlspecialchars($fetchUser['u_profile_img']); ?>" width="150" height="150" style="border-radius:50%; object-fit:cover; border:3px solid #ddd;">
                            <?php } else { ?>
                                <img src="assets/img/user.png" width="150" height="150" style="border-radius:50%; object-fit:cover; border:3px solid #ddd;">
                            <?php } ?>

                            <div class="productdetails mt-3 text-left">
                                <ul class="product-bar">
                                    <li><h4>Name</h4><h6><?= htmlspecialchars($fetchUser['u_name']); ?></h6></li>
                                    <li><h4>Designation</h4><h6><?= htmlspecialchars($fetchUser['u_designation']); ?></h6></li>
                                    <li><h4>Email</h4><h6><?= htmlspecialchars($fetchUser['u_email']); ?></h6></li>
                                    <li><h4>Password</h4><h6><?= htmlspecialchars($fetchUser['u_password']); ?></h6></li>
                                </ul>
                            </div>

                            <hr>

                            <!-- ✅ NIC/Bayform Upload Section -->
                            <h5>NIC/Bayform Document</h5>

                            <?php if (!empty($fetchUser['u_nic_bayform']) && file_exists($fetchUser['u_nic_bayform'])) { ?>
                                <p>
                                    <a href="<?= $fetchUser['u_nic_bayform']; ?>" target="_blank" class="btn btn-success btn-sm me-2">
                                        <i class="fa fa-eye"></i> View File
                                    </a>
                                    <a href="<?= $fetchUser['u_nic_bayform']; ?>" download class="btn btn-info btn-sm">
                                        <i class="fa fa-download"></i> Download
                                    </a>
                                </p>
                            <?php } else { ?>
                                <p><em>No NIC/Bayform uploaded yet.</em></p>
                            <?php } ?>

                            <form method="post" enctype="multipart/form-data" class="mt-3">
                                <input type="file" name="nic_file" accept=".pdf,.png" required class="form-control mb-2">
                                <button type="submit" name="upload_nic" class="btn btn-submit me-2">Upload NIC/Bayform</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Right Column (Emergency Contacts) -->
                <div class="col-md-6">

                    <!-- Contact 1 -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <h4><strong>Emergency Contact 1</strong></h4>
                            <form class="row" method="post">
                                <input type="hidden" name="contact_id" value="<?= $contact1['ec_id'] ?>">
                                <div class="col-12">
                                    <label>Name</label>
                                    <input type="text" name="name" value="<?= htmlspecialchars($contact1['ec_name']); ?>" required class="form-control">
                                </div>
                                <div class="col-12">
                                    <label>Relation</label>
                                    <input type="text" name="relation" value="<?= htmlspecialchars($contact1['ec_relation']); ?>" required class="form-control">
                                </div>
                                <div class="col-12">
                                    <label>Contact</label>
                                    <input type="text" name="contact" value="<?= htmlspecialchars($contact1['ec_number']); ?>" required class="form-control">
                                </div>
                                <div class="col-lg-12 mt-3">
                                    <?php if ($contact1['ec_id']) { ?>
                                        <button type="submit" name="update" class="btn btn-submit me-2">Update Contact</button>
                                    <?php } else { ?>
                                        <button type="submit" name="add" class="btn btn-submit me-2">Add Contact</button>
                                    <?php } ?>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Contact 2 -->
                    <div class="card">
                        <div class="card-body">
                            <h4><strong>Emergency Contact 2</strong></h4>
                            <form class="row" method="post">
                                <input type="hidden" name="contact_id" value="<?= $contact2['ec_id'] ?>">
                                <div class="col-12">
                                    <label>Name</label>
                                    <input type="text" name="name" value="<?= htmlspecialchars($contact2['ec_name']); ?>" required class="form-control">
                                </div>
                                <div class="col-12">
                                    <label>Relation</label>
                                    <input type="text" name="relation" value="<?= htmlspecialchars($contact2['ec_relation']); ?>" required class="form-control">
                                </div>
                                <div class="col-12">
                                    <label>Contact</label>
                                    <input type="text" name="contact" value="<?= htmlspecialchars($contact2['ec_number']); ?>" required class="form-control">
                                </div>
                                <div class="col-lg-12 mt-3">
                                    <?php if ($contact2['ec_id']) { ?>
                                        <button type="submit" name="update" class="btn btn-submit me-2">Update Contact</button>
                                    <?php } else { ?>
                                        <button type="submit" name="add" class="btn btn-submit me-2">Add Contact</button>
                                    <?php } ?>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table datanew">
                                    <thead>
                                        <tr>
                                            <th>S. No</th>
                                            <th>Date</th>
                                            <th>Time In</th>
                                            <th>Time Out</th>
                                            <th>Hours Worked</th>
                                            <th>Actual Time In</th>
                                            <th>Actual Time Out</th>
                                            <th>Hours Needed</th>
                                            <th>Status</th>
                                            <th>Progress</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $sno = 1;
                                            $attendance = mysqli_query($con,"SELECT * FROM attendance WHERE a_user='$userId' ORDER BY a_date DESC");
                                            while ($fetchAttendance = mysqli_fetch_assoc($attendance)) {
                                                $hoursWorked = '';
                                                $timeIn = $fetchAttendance['a_time_in'] ? strtotime($fetchAttendance['a_date'] . ' ' . $fetchAttendance['a_time_in']) : null;
                                                $timeOut = ($fetchAttendance['a_time_out'] && $fetchAttendance['a_time_out'] !== '00:00:00')
                                                    ? strtotime($fetchAttendance['a_date'] . ' ' . $fetchAttendance['a_time_out']) : null;

                                                if ($timeOut && $timeIn) {
                                                    $diffInSeconds = $timeOut - $timeIn;
                                                    if ($diffInSeconds < 0) $diffInSeconds = 0;
                                                    $hoursWorked = sprintf('%02d:%02d:%02d',
                                                        floor($diffInSeconds / 3600),
                                                        floor(($diffInSeconds % 3600) / 60),
                                                        $diffInSeconds % 60
                                                    );
                                                } else if ($timeIn && !$timeOut) {
                                                    $timerId = "timer-row-" . $fetchAttendance['a_id'];
                                                    $hoursWorked = '<p id="'.$timerId.'" class="row-timer">00:00:00</p>';
                                                    $activeTimers[] = [
                                                        'id' => $timerId,
                                                        'start_ts' => $timeIn
                                                    ];
                                                } else {
                                                    $hoursWorked = '00:00:00';
                                                }
                                                $actualTimeIn  = $fetchAttendance['a_actual_time_in'] ? strtotime($fetchAttendance['a_date'] . ' ' . $fetchAttendance['a_actual_time_in']) : null;
                                                $actualTimeOut = $fetchAttendance['a_actual_time_out'] ? strtotime($fetchAttendance['a_date'] . ' ' . $fetchAttendance['a_actual_time_out']) : null;
                                                $actualDiffInSeconds = ($actualTimeIn && $actualTimeOut) ? max(0, $actualTimeOut - $actualTimeIn) : 0;
                                                $hoursNeeded = sprintf('%02d:%02d:%02d',
                                                    floor($actualDiffInSeconds / 3600),
                                                    floor(($actualDiffInSeconds % 3600) / 60),
                                                    $actualDiffInSeconds % 60
                                                );
                                                $status = '<span class="badges bg-lightyellow">On Time</span>';
                                                if ($timeIn && $actualTimeIn) {
                                                    if ($timeIn > $actualTimeIn + 900) { // more than 15 min late
                                                        $status = '<span class="badges bg-lightred">Late</span>';
                                                    } elseif ($timeIn < $actualTimeIn) {
                                                        $status = '<span class="badges bg-lightgreen">Before Time</span>';
                                                    }
                                                }
                                        ?>
                                        <tr>
                                            <td><?= $sno ?></td>
                                            <td><?= $fetchAttendance['a_date'] ?></td>
                                            <td><?= $fetchAttendance['a_time_in'] ?></td>
                                            <td><?= $fetchAttendance['a_time_out'] ?></td>
                                            <td><?= $hoursWorked ?></td>
                                            <td><?= $fetchAttendance['a_actual_time_in'] ?></td>
                                            <td><?= $fetchAttendance['a_actual_time_out'] ?></td>
                                            <td><?= $hoursNeeded ?></td>
                                            <td><?= $status ?></td>
                                            <td><a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#view-progress-<?= $fetchAttendance['a_id'] ?>">View</a></td>
                                        </tr>
                                        <div id="view-progress-<?= $fetchAttendance['a_id'] ?>" class="modal custom-modal fade" role="dialog">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <h6><?= $fetchAttendance['a_timesheet'] ?></h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php 
                                                $sno++;
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
            </div><!-- /row -->

        </div>
    </div>
</div>

<?php include 'footer-files.php'; ?>
</body>
</html>
<?php 
        } else {
            $_SESSION['toastr_message'] = "Please Login First!";
            $_SESSION['toastr_type'] = "info";
            header("Location: login.php");
            exit();
        }
    } else {
        $_SESSION['toastr_message'] = "You don't have right to access the desired Resource!";
        $_SESSION['toastr_type'] = "info";
        header("Location: index.php");
        exit();
    }
} else {
    echo 'Invalid IP Access. Your IP Address is '.$yourIP;
}
?>
