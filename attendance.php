<?php 
    include 'config.php';
    if ($hasAdminRights) {
        if (isset($_SESSION['as_user'])) {
            $attendanceActive = 'active';
        
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Attendance</title>
        <?php include 'header-files.php' ?>
        <!-- Datatable CSS -->
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
							<h4>Add Attendance Record</h4>
						</div>
					</div>
					<div class="card">
						<div class="card-body">
							<form class="row" method="post">
                                <div class="col-md-3">
									<div class="form-group">
										<label>User Name</label>
										<select name="user">
                                            <option>Select User</option>
                                            <?php 
                                            foreach($usersFileData as $row){
                                                $elements = explode(',', $row);
                                                if($elements[5] == 0){
                                                    continue;
                                                }
                                            ?>
                                            <option value="<?= $elements[0] ?>"><?= $elements[1] ?></option>
                                            <?php 
                                            }
                                            ?>
                                        </select>
									</div>
								</div>	
                                <div class="col-md-3">
									<div class="form-group">
										<label>Date</label>
										<input style="width:100%" type="date" name="date">
									</div>
								</div>	
                                <div class="col-md-3">
									<div class="form-group">
										<label>Clock In</label>
										<input style="width:100%" type="time" name="clockIn">
									</div>
								</div>	
								<div class="col-md-3">
									<div class="form-group">
										<label>Clock Out</label>
										<input style="width:100%" type="time" name="clockOut">
									</div>
								</div>	
								<div class="col-lg-12">
									<button href="javascript:void(0);" type="submit" name="add" class="btn btn-submit me-2">Add Record</button>
								</div>
                            </form>
						</div>
					</div>
                    <div class="page-header">
						<div class="page-title">
							<h4>Attendance Details</h4>
						</div>
					</div>
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table datanew">
                                    <thead>
                                        <tr>
                                            <th>S. No</th>
                                            <th>User Name</th>
                                            <th>Date</th>
                                            <th>Clock In</th>
                                            <th>Clock Out</th>
                                            <th>Hours Worked</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $sno = 1;
                                        foreach($attendanceFileData as $row){
                                            $elements = explode(',', $row);
                                            foreach($usersFileData as $userRow){
                                                $userElements = explode(',', $userRow);
                                                if($userElements[0] == $elements[5]){
                                                    $userName = $userElements[1];
                                                    break;
                                                }
                                            }
                                            $a = new DateTime($elements[2]);
                                            $b = new DateTime($elements[3]);
                                            $interval = $a->diff($b);
                                        ?>
                                        <tr>
                                            <td><?= $sno ?></td>
                                            <td><?= $userName ?></td>
                                            <td><?= $elements[1] ?></td>
                                            <td><?= $elements[2] ?></td>
                                            <td><?= $elements[3] ?></td>
                                            <td><?= $interval->format("%H:%i") ?></td>
                                            <td>
                                                <a href="attendance.php?attendanceId=<?= $elements[0] ?>"><i class="fa fa-edit" data-bs-toggle="tooltip" title="Edit"></i></a>
                                                <a href="code.php?type=attendanceDelete&attendanceId=<?= $elements[0] ?>"><i class="fa fa-trash" data-bs-toggle="tooltip" title="Delete"></i></a>
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
    include 'footer-files.php';
?>	
<!-- Datatable JS -->
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/dataTables.bootstrap4.min.js"></script>