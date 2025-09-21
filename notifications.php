<?php 
    include 'config.php';
    if(in_array($yourIP, $ipArray)) {
        if ($hasAdminRights) {
            if (isset($_SESSION['as_user'])) {
                $notificationsActive = 'active';

                if (isset($_POST['addNotification'])) {
                    try {
                        $title = $_POST['title'];
                        $user = $_POST['user'];
                        $content = $_POST['content'];

                        mysqli_query($con,"INSERT INTO `notifications`(n_title, n_content, n_user, n_date_time, n_status) 
                        VALUES ('$title','$content','$user','$currentDateTime', '1')");
                        $_SESSION['toastr_message'] = "Notification Has been Added Successfully!";
                        $_SESSION['toastr_type'] = "success";
                        header("Location: notifications.php");
                        exit();
                    } catch (Exception $e) {
                        $_SESSION['toastr_message'] = "Something went wrong: " . $e->getMessage();
                        $_SESSION['toastr_type'] = "error";
                        header("Location: notifications.php");
                        exit();
                    } 
                }

                $notificationId = $_GET['notificationId'];
                $notification = mysqli_query($con, "SELECT * FROM notifications WHERE n_id='$notificationId'");
                $fetchNotification = mysqli_fetch_assoc($notification);
                
                if (isset($_POST['updateNotification'])) {
                    try {
                        $title = $_POST['title'];
                        $user = $_POST['user'];
                        $content = $_POST['content'];

                        mysqli_query($con,"UPDATE notifications SET n_title='$title', n_user='$user', n_content='$content' WHERE n_id='$notificationId'");
                        $_SESSION['toastr_message'] = "Notification Has been Updated Successfully!";
                        $_SESSION['toastr_type'] = "success";
                        header("Location: notifications.php");
                        exit();
                    } catch (Exception $e) {
                        $_SESSION['toastr_message'] = "Something went wrong: " . $e->getMessage();
                        $_SESSION['toastr_type'] = "error";
                        header("Location: notifications.php");
                        exit();
                    } 
                }
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Notifications</title>
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
							<h4>Add Notification</h4>
						</div>
					</div>
					<div class="card">
						<div class="card-body">
							<form class="row" method="post">
								<div class="col-md-4">
									<div class="form-group">
										<label>Title</label>
										<input type="text" name="title" value="<?= $fetchNotification['n_title'] ?>">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>To</label>
                                        <select name="user" class="form-control" required>
                                            <option value="0">All Users</option>
                                            <?php 
                                            $users = mysqli_query($con,"SELECT u_id, u_name FROM users WHERE u_role='User'");
                                            while ($fetchUsers = mysqli_fetch_assoc($users)) {
                                                $selected = '';
                                                $selected = ($fetchNotification['n_user'] == $fetchUsers['u_id']) ? 'selected' : '';
                                            ?>
                                                <option value="<?= $fetchUsers['u_id'] ?>" <?= $selected ?>><?= $fetchUsers['u_name'] ?></option>
                                            <?php } ?>
                                        </select>
									</div>
								</div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Content</label>
                                        <textarea name="content" class="form-control"><?= $fetchNotification['n_content'] ?></textarea>
                                    </div>
                                </div>
								<div class="col-lg-12">
                                    <?php if ($notificationId) { ?>
									<button type="submit" name="updateNotification" class="btn btn-submit me-2">Update Notification</button>
                                    <?php } else { ?>
									<button type="submit" name="addNotification" class="btn btn-submit me-2">Add Notification</button>
                                    <?php } ?>
								</div>
                            </form>
						</div>
					</div>
                    <div class="page-header">
						<div class="page-title">
							<h4>Notifications List</h4>
						</div>
					</div>
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table datanew">
                                    <thead>
                                        <tr>
                                            <th>S. No</th>
                                            <th>Title</th>
                                            <th>Content</th>
                                            <th>Posted At</th>
                                            <th>For</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $sno = 1;
                                            $notifications = mysqli_query($con,"SELECT a.*, b.u_name FROM notifications a LEFT JOIN users b ON a.n_user=b.u_id");
                                            while ($fetchNotifications = mysqli_fetch_assoc($notifications)) {
                                                $userName = $fetchNotifications['u_name'];
                                                if (!$fetchNotifications['u_name']) {
                                                    $userName = 'All Users';
                                                }
                                                $status = '<span class="badges bg-lightgreen">Active</span><br>
                                                <a href="code.php?type=deactivateNotification&notificationId='.$fetchNotifications['n_id'].'" style="color: red">Deactivate</a>';
                                                if ($fetchNotifications['n_status'] == 0) {
                                                    $status = '<span class="badges bg-lightred">InActive</span><br>
                                                    <a href="code.php?type=activateNotification&notificationId='.$fetchNotifications['n_id'].'" style="color: green">Activate</a>';
                                                }
                                        ?>
                                        <tr>
                                            <td><?= $sno ?></td>
                                            <td><?= $fetchNotifications['n_title'] ?></td>
                                            <td><?= $fetchNotifications['n_content'] ?></td>
                                            <td><?= $fetchNotifications['n_date_time'] ?></td>
                                            <td><?= $userName ?></td>
                                            <td><?= $status ?></td>
                                            <td>
                                                <a href="notifications.php?notificationId=<?= $fetchNotifications['n_id'] ?>"><img src="assets/img/icons/edit.svg" alt="img" data-bs-toggle="tooltip" title="Edit"></a>
                                                <a href="code.php?type=deleteNotification&notificationId=<?= $fetchNotifications['n_id'] ?>"><img src="assets/img/icons/delete.svg" alt="img" data-bs-toggle="tooltip" title="Delete"></a>
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
