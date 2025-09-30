<?php 
    include 'config.php';
    if(in_array($yourIP, $ipArray)) {
        if ($hasAdminRights) {
            if (isset($_SESSION['as_user'])) {
                $usersActive = 'active';

                if (isset($_POST['add'])) {
                    try {
                        $name = $_POST['name'];
                        $email = $_POST['email'];
                        $password = $_POST['password'];
                        $designation = $_POST['designation'];
                        $salary = $_POST['salary'];
                        $dob = $_POST['dob'];
                        $joiningDate = $_POST['joiningDate'];
                        $timeIn = $_POST['timeIn'];
                        $timeOut = $_POST['timeOut'];
                        $workingDays = $_POST['workingDays'];
                        mysqli_query($con,"INSERT INTO users(u_name, u_email, u_password, u_role, u_status, u_designation, u_salary, u_job_type, u_dob, u_joining_date, u_working_days, u_time_in, u_time_out)
                        VALUES('$name', '$email', '$password', 'User', '1', '$designation', '$salary', 'Probation', '$dob', '$joiningDate', '$workingDays', '$timeIn', '$timeOut')");
                        $_SESSION['toastr_message'] = "User Has been Added Successfully!";
                        $_SESSION['toastr_type'] = "success";
                        header("Location: users.php");
                        exit();
                    } catch (Exception $e) {
                        $_SESSION['toastr_message'] = "Something went wrong: " . $e->getMessage();
                        $_SESSION['toastr_type'] = "error";
                        header("Location: users.php");
                        exit();
                    } 
                }

                $userId = $_GET['userId'];
                $user = mysqli_query($con,"SELECT * FROM `users` WHERE u_id='$userId'");
                if ($userId && mysqli_num_rows($user) == 0) {
                    $_SESSION['toastr_message'] = "Invalid Access!";
                    $_SESSION['toastr_type'] = "error";
                    header("Location: users.php");
                    exit();
                }
                $fetchUser = mysqli_fetch_assoc($user);

                if(isset($_POST['update'])){
                    try {
                        $name = $_POST['name'];
                        $email = $_POST['email'];
                        $password = $_POST['password'];
                        $designation = $_POST['designation'];
                        $salary = $_POST['salary'];
                        $dob = $_POST['dob'];
                        $joiningDate = $_POST['joiningDate'];
                        $timeIn = $_POST['timeIn'];
                        $timeOut = $_POST['timeOut'];
                        $workingDays = $_POST['workingDays'];
                        mysqli_query($con,"UPDATE users SET u_name='$name', u_email='$email', u_password='$password', u_designation='$designation', u_salary='$salary', u_joining_date='$joiningDate', u_dob='$dob', u_working_days='$workingDays', u_time_in='$timeIn', u_time_out='$timeOut' WHERE u_id='$userId'");
                        $_SESSION['toastr_message'] = "User Has been Updated Successfully!";
                        $_SESSION['toastr_type'] = "success";
                        header("Location: users.php");
                        exit();
                    } catch (Exception $e) {
                        $_SESSION['toastr_message'] = "Something went wrong: " . $e->getMessage();
                        $_SESSION['toastr_type'] = "error";
                        header("Location: users.php");
                        exit();
                    }
                }     
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Users</title>
        <?php include 'header-files.php' ?>
        <link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css">
	</head>
	<body>
		<div class="main-wrapper">
            <?php include 'header.php' ?>
            <?php include 'sidebar.php' ?>
			<div class="page-wrapper">
				<div class="content">
					<div class="page-header">
						<div class="page-title">
							<h4><?= ($userId) ? 'Update' : 'Add' ?> User</h4>
						</div>
					</div>
					<div class="card">
						<div class="card-body">
							<form class="row" method="post">
								<div class="col-md-4">
									<div class="form-group">
										<label>User Name</label>
										<input type="text" name="name" value="<?= $fetchUser['u_name'] ?>">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>User Email</label>
										<input type="text" name="email" value="<?= $fetchUser['u_email'] ?>">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Password</label>
										<input type="text" name="password" value="<?= $fetchUser['u_password'] ?>">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Designation</label>
										<input type="text" name="designation" value="<?= $fetchUser['u_designation'] ?>">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Salary</label>
										<input type="text" name="salary" value="<?= $fetchUser['u_salary'] ?>">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Date of Birth</label>
										<input type="date" name="dob" value="<?= $fetchUser['u_dob'] ?>">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Joining Date</label>
										<input type="date" name="joiningDate" value="<?= $fetchUser['u_joining_date'] ?>">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Time In</label>
										<input type="time" name="timeIn" value="<?= $fetchUser['u_time_in'] ?>">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Time Out</label>
										<input type="time" name="timeOut" value="<?= $fetchUser['u_time_out'] ?>">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Working Days</label>
										<input type="number" name="workingDays" value="<?= $fetchUser['u_working_days'] ?>">
									</div>
								</div>
								<div class="col-lg-12">
                                    <?php if ($userId) { ?>
									<button type="submit" name="update" class="btn btn-submit me-2">Update User</button>
                                    <?php } else { ?>
									<button type="submit" name="add" class="btn btn-submit me-2">Add User</button>
                                    <?php } ?>
								</div>
                            </form>
						</div>
					</div>
                    <div class="page-header">
						<div class="page-title">
							<h4>Users List</h4>
						</div>
					</div>
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table  datanew ">
                                    <thead>
                                        <tr>
                                            <th>S. No</th>
                                            <th>Profile</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Password</th>
                                            <th>Designation</th>
                                            <th>Salary</th>
                                            <th>Date Of Birth</th>
                                            <th>Joining Date</th>
                                            <th>Working Days</th>
                                            <th>Timmings</th>
                                            <th>Status</th>
                                            <th>Job Type</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $sno = 1;
                                            $users = mysqli_query($con,"SELECT * FROM `users` WHERE u_role='User'");
                                            while ($fetchUsers = mysqli_fetch_assoc($users)) {
                                                $img = '';
                                                $status = '<span class="badges bg-lightgreen">Active</span><br>
                                                <a href="code.php?type=deactivateUser&userId='.$fetchUsers['u_id'].'" style="color: red">Deactivate</a>';
                                                $jobType = '<span class="badges bg-lightgreen">Permanent</span><br>
                                                <a href="code.php?type=moveToNoticePeriod&userId='.$fetchUsers['u_id'].'">Shift to Notice Period</a>';
                                                if ($fetchUsers['u_profile_img']) {
                                                    $img = '<img height="50px" width="50px" src="user-profile-imgs/'.$fetchUsers['u_profile_img'].'" alt="">';
                                                }
                                                if ($fetchUsers['u_status'] == 0) {
                                                    $status = '<span class="badges bg-lightred">Inactive</span><br>
                                                    <a href="code.php?type=activateUser&userId='.$fetchUsers['u_id'].'" style="color: green">Activate</a>';
                                                }
                                                if ($fetchUsers['u_job_type'] == 'Probation') {
                                                    $jobType = '<span class="badges bg-lightyellow">Probation</span><br>
                                                    <a href="code.php?type=moveToPermanent&userId='.$fetchUsers['u_id'].'">Promote to Permanent Position</a>';
                                                }
                                                if ($fetchUsers['u_job_type'] == 'Notice Period') {
                                                    $jobType = '<span class="badges bg-lightred">On Notice Period</span>';
                                                }
                                        ?>
                                        <tr>
                                            <td><?= $sno ?></td>
                                            <td><?= $img ?></td>
                                            <td><?= $fetchUsers['u_name'] ?></td>
                                            <td><?= $fetchUsers['u_email'] ?></td>
                                            <td><?= $fetchUsers['u_password'] ?></td>
                                            <td><?= $fetchUsers['u_designation'] ?></td>
                                            <td>PKR <?= $fetchUsers['u_salary'] ?></td>
                                            <td><?= $fetchUsers['u_dob'] ?></td>
                                            <td><?= $fetchUsers['u_joining_date'] ?></td>
                                            <td><?= $fetchUsers['u_working_days'] ?></td>
                                            <td><?= $fetchUsers['u_time_in'].' till '.$fetchUsers['u_time_out'] ?></td>
                                            <td><?= $status ?></td>
                                            <td><?= $jobType ?></td>
                                            <td>
                                                <a href="user-details.php?userId=<?= $fetchUsers['u_id'] ?>">
                                                    <img src="assets/img/icons/excel.svg" alt="img" data-bs-toggle="tooltip" title="View Details">
                                                </a>
                                                <a href="users.php?userId=<?= $fetchUsers['u_id'] ?>">
                                                    <img src="assets/img/icons/edit.svg" alt="img" data-bs-toggle="tooltip" title="Edit">
                                                </a>
                                                <a href="javascript:void(0);" class="confirm-delete" data-id="<?= $fetchUsers['u_id'] ?>">
                                                    <img src="assets/img/icons/delete.svg" alt="img" data-bs-toggle="tooltip" title="Delete">
                                                </a>
                                            </td>
                                        </tr>
                                        <?php 
                                                $sno++;
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
    include 'footer-files.php';
?>	
<!-- Datatable JS -->
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).on("click", ".confirm-delete", function(e) {
        e.preventDefault();
        var id = $(this).data("id");

        Swal.fire({
            title: 'Are you sure?',
            text: "This User will be permanently deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#FF9F43',
            cancelButtonColor: '#f5365c', 
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = "code.php?type=deleteUser&userId=" + id;
            }
        });
    });
</script>
