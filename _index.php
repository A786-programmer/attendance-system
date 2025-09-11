<?php 
include 'config.php';
if($_SERVER['REMOTE_ADDR'] == $ipAddressFileData[0] || $_SERVER['REMOTE_ADDR'] == $ipAddressFileData[1]) {
    if(isset($_SESSION['userId'])){
        $indexActive = 'active';
        $attendanceActive = '';
        $usersActive = '';
        $adminsActive = '';
        $clockInDisabled = '';
        $clockOutDisabled = '';
        $todayClockIn = '--:--';
        $todayClockOut = '--:--';

        foreach($attendanceFileData as $row){
            $elements = explode(',', $row);
            if($_SESSION['userId'] == $elements[5] && $elements[1] == $currentDate){
                $clockInDisabled = 'disabled';
                $todayClockIn = $elements[2];
                break;
            }
        }

        foreach($attendanceFileData as $row){
            $elements = explode(',', $row);
            if($_SESSION['userId'] == $elements[5] && $elements[1] == $currentDate && $elements[4] == 1){
                $clockOutDisabled = 'disabled';
                $todayClockOut = $elements[3];
                break;
            }
        }
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Home</title>
        <?php include 'header-files.php' ?>
	</head>
	<body onload="startTime()">
		<div class="main-wrapper">
            <?php include 'header.php' ?>
            <?php include 'sidebar.php' ?>
			<div class="page-wrapper">
				<div class="content">
                    <?php 
                    if($currentUser[5] == 1){
                    ?>
					<div class="row">
                        <div class="col-md-2 col-sm-6 col-12"></div>
						<div class="col-md-3 col-sm-6 col-12">
							<div class="dash-count">
								<div class="dash-counts">
									<h4><?= $standardClockIn ?></h4>
									<h5>Standard Clock-In</h5>
								</div>
							</div>
						</div>
						<div class="col-md-2 col-sm-6 col-12">
							<div class="dash-count das1">
								<div class="dash-counts">
									<h4 id="txt"></h4>
									<h5>Current Time</h5>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-sm-6 col-12">
							<div class="dash-count das2">
								<div class="dash-counts">
									<h4><?= $standardClockOut ?></h4>
									<h5>Standard Clock-Out</h5>
								</div>
							</div>
						</div>
						<div class="col-md-2 col-sm-6 col-12"></div>
						<div class="col-md-2 col-sm-6 col-12"></div>
                        <div class="col-md-3 col-sm-6 col-12">
							<div class="dash-count">
								<div class="dash-counts">
									<h4><?= $todayClockIn ?></h4>
									<h5>Today's Clock-In</h5>
								</div>
							</div>
						</div>
						<div class="col-md-2 col-sm-6 col-12">
                            <button <?= $clockInDisabled ?> class="btn btn-danger w-100" onclick="addClockIn()" type="submit" name="clockIn" style="">Clock In</button>
                            <button <?= $clockOutDisabled ?> class="btn btn-danger w-100" onclick="addClockOut()" type="submit" name="clockOut" style="margin-top:20px; margin-bottom:20px">Clock Out</button>
                        </div>
						<div class="col-md-3 col-sm-6 col-12">
							<div class="dash-count das2">
								<div class="dash-counts">
									<h4><?= $todayClockOut ?></h4>
									<h5>Today's Clock-Out</h5>
								</div>
							</div>
						</div>
						<div class="col-md-2 col-sm-6 col-12"></div>
					</div>
                    <?php 
                    }
                    if($currentUser[5] == 0){
                    ?>
                    <div class="page-header">
                        <div class="page-title">
                            <h4>Update IP Address</h4>
                        </div>
                    </div>
                    <div class="card">
						<div class="card-body">
							<div class="row">
                                <div class="col-md-6">
									<div class="form-group">
										<input value="<?= $ipAddressFileData[0] ?>" style="width:100%; height:35px" type="text" id="ipAddress1">
									</div>
								</div>	
                                <div class="col-md-6">
									<div class="form-group">
										<input value="<?= $ipAddressFileData[1] ?>" style="width:100%; height:35px" type="text" id="ipAddress2">
									</div>
								</div>	
								<div class="col-lg-12">
									<button onclick="updateIP()" class="btn btn-submit me-2">Update IP Address</button>
								</div>
                            </div>
						</div>
					</div>
                    <div class="page-header">
                        <div class="page-title">
                            <h4>Update App Settings</h4>
                        </div>
                    </div>
                    <div class="card">
						<div class="card-body">
                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>Days</th>
                                        <th>Clock In</th>
                                        <th>Clock Out</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Monday</td>
                                        <td><input style="width:100%" type="time" id="mondayClockIn" value="<?= $mondayClockIn ?>"></td>
                                        <td><input style="width:100%" type="time" id="mondayClockOut" value="<?= $mondayClockOut ?>"></td>
                                    </tr>
                                    <tr>
                                        <td>Tuesday</td>
                                        <td><input style="width:100%" type="time" id="tuesdayClockIn" value="<?= $tuesdayClockIn ?>"></td>
                                        <td><input style="width:100%" type="time" id="tuesdayClockOut" value="<?= $tuesdayClockOut ?>"></td>
                                    </tr>
                                    <tr>
                                        <td>Wednesday</td>
                                        <td><input style="width:100%" type="time" id="wednesdayClockIn" value="<?= $wednesdayClockIn ?>"></td>
                                        <td><input style="width:100%" type="time" id="wednesdayClockOut" value="<?= $wednesdayClockOut ?>"></td>
                                    </tr>
                                    <tr>
                                        <td>Thursday</td>
                                        <td><input style="width:100%" type="time" id="thursdayClockIn" value="<?= $thursdayClockIn ?>"></td>
                                        <td><input style="width:100%" type="time" id="thursdayClockOut" value="<?= $thursdayClockOut ?>"></td>
                                    </tr>
                                    <tr>
                                        <td>Friday</td>
                                        <td><input style="width:100%" type="time" id="fridayClockIn" value="<?= $fridayClockIn ?>"></td>
                                        <td><input style="width:100%" type="time" id="fridayClockOut" value="<?= $fridayClockOut ?>"></td>
                                    </tr>
                                    <tr>
                                        <td>Saturday</td>
                                        <td><input style="width:100%" type="time" id="saturdayClockIn" value="<?= $saturdayClockIn ?>"></td>
                                        <td><input style="width:100%" type="time" id="saturdayClockOut" value="<?= $saturdayClockOut ?>"></td>
                                    </tr>
                                    <tr>
                                        <td>Sunday</td>
                                        <td><input style="width:100%" type="time" id="sundayClockIn" value="<?= $sundayClockIn ?>"></td>
                                        <td><input style="width:100%" type="time" id="sundayClockOut" value="<?= $sundayClockOut ?>"></td>
                                    </tr>
                                </tbody>
                            </table>
							<div class="row" style="margin-top:20px">
								<div class="col-lg-12">
									<button onclick="updateTime()" name="update" class="btn btn-submit me-2">Update Timmings</button>
								</div>
                            </div>
						</div>
					</div>
                    <div class="page-header">
                        <div class="page-title">
                            <h4>Fetch Records for Payroll</h4>
                        </div>
                    </div>
                    <div class="card">
						<div class="card-body">
							<div class="row">
								<!-- <div class="col-md-4">
									<div class="form-group">
										<label>User Name</label>
										<select style="width:100%; height:35px" id="userId">
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
								</div>	 -->
								<div class="col-md-6">
									<div class="form-group">
										<label>Start Date</label>
										<input style="width:100%; height:35px" type="date" id="startDate">
									</div>
								</div>	
								<div class="col-md-6">
									<div class="form-group">
										<label>End Date</label>
										<input style="width:100%; height:35px" type="date" id="endDate">
									</div>
								</div>	
								<div class="col-lg-12">
									<button onclick="getRecord()" name="update" class="btn btn-submit me-2">Get Record</button>
								</div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped mb-0">
                                            <thead>
                                                <tr>
                                                    <th>S. No</th>
                                                    <th>Date</th>
                                                    <th>Check In</th>
                                                    <th>Check Out</th>
                                                    <th>Hours Worked</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tableContent">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
						</div>
					</div>
                    <?php 
                    }
                    ?>
				</div>
			</div>
		</div>	
	</body>
</html>
<?php 
    }
    else{
        echo'<script>window.location="login.php";</script>';
    }
}
else{
    echo 'Invalid IP Access';
}
include 'footer-files.php';
?>
<script>
    function startTime() {
        const today = new Date();
        let h = today.getHours();
        let m = today.getMinutes();
        let s = today.getSeconds();
        m = checkTime(m);
        s = checkTime(s);
        document.getElementById('txt').innerHTML =  h + ":" + m + ":" + s;
        setTimeout(startTime, 1000);
    }

    function checkTime(i) {
        if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
        return i;
    }

    function updateTime() {
        var mondayClockIn = document.getElementById('mondayClockIn').value;
        var mondayClockOut = document.getElementById('mondayClockOut').value;
        var tuesdayClockIn = document.getElementById('tuesdayClockIn').value;
        var tuesdayClockOut = document.getElementById('tuesdayClockOut').value;
        var wednesdayClockIn = document.getElementById('wednesdayClockIn').value;
        var wednesdayClockOut = document.getElementById('wednesdayClockOut').value;
        var thursdayClockIn = document.getElementById('thursdayClockIn').value;
        var thursdayClockOut = document.getElementById('thursdayClockOut').value;
        var fridayClockIn = document.getElementById('fridayClockIn').value;
        var fridayClockOut = document.getElementById('fridayClockOut').value;
        var saturdayClockIn = document.getElementById('saturdayClockIn').value;
        var saturdayClockOut = document.getElementById('saturdayClockOut').value;
        var sundayClockIn = document.getElementById('sundayClockIn').value;
        var sundayClockOut = document.getElementById('sundayClockOut').value;
        $.ajax({
            url: 'code.php',
            type: 'GET',
            data: {
                type: 'updateTime',
                mondayClockIn: mondayClockIn,
                mondayClockOut: mondayClockOut,
                tuesdayClockIn: tuesdayClockIn,
                tuesdayClockOut: tuesdayClockOut,
                wednesdayClockIn: wednesdayClockIn,
                wednesdayClockOut: wednesdayClockOut,
                thursdayClockIn: thursdayClockIn,
                thursdayClockOut: thursdayClockOut,
                fridayClockIn: fridayClockIn,
                fridayClockOut: fridayClockOut,
                saturdayClockIn: saturdayClockIn,
                saturdayClockOut: saturdayClockOut,
                sundayClockIn: sundayClockIn,
                sundayClockOut: sundayClockOut
            },
            dataType: 'text',
            success: function(data){
                if(data == 1){
                    alert('Time Updated');
                }
                else if(data == 0){
                    alert('Server Error');
                }
                else{
                    alert('Invalid Error')
                }
            }
        });
    }

    function updateIP() {
        var ipAddress1 = document.getElementById('ipAddress1').value;
        var ipAddress2 = document.getElementById('ipAddress2').value;
        $.ajax({
            url: 'code.php',
            type: 'GET',
            data: {
                type: 'updateIP',
                ipAddress1: ipAddress1,
                ipAddress2: ipAddress2
            },
            dataType: 'text',
            success: function(data){
                if(data == 1){
                    alert('IP Address updated!');
                }
                else if(data == 0){
                    alert('Server Error');
                }
            }
        });
    }

    function addClockIn() {
        $.ajax({
            url: 'code.php',
            type: 'GET',
            data: {
                type: 'addClockIn'
            },
            dataType: 'text',
            success: function(data){
                if(data == 1){
                    alert('Clocked In');
                    window.location.replace('index.php');
                }
                else if(data == 0){
                    alert('Server Error');
                }
                else if(data == 2){
                    alert('Time Exceeds the range');
                }
                else if(data == 3){
                    alert('Error in opening the file');
                }
                else{
                    alert('Invalid Error');
                }
            }
        });
    }

    function addClockOut() {
        $.ajax({
            url: 'code.php',
            type: 'GET',
            data: {
                type: 'addClockOut'
            },
            dataType: 'text',
            success: function(data){
                if(data == 1){
                    alert('Clocked Out');
                    window.location.replace('index.php');
                }
                else if(data == 0){
                    alert('Server Error');
                }
                else if(data == 2){
                    alert('Please Clock In First');
                }
                else{
                    alert('Invalid Error')
                }
            }
        });
    }

    function getRecord() {
        // var userId = document.getElementById('userId').value;
        var startDate = document.getElementById('startDate').value;
        var endDate = document.getElementById('endDate').value;
        $.ajax({
            url: 'code.php',
            type: 'GET',
            data: {
                type: 'getRecord',
                // userId: userId,
                startDate: startDate,
                endDate: endDate
            },
            dataType: 'text',
            success: function(data){
                console.log(data);
                document.getElementById('tableContent').innerHTML = data;
            }
        });
    }
</script>
<!-- Datatable JS -->
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/dataTables.bootstrap4.min.js"></script>
<!-- Chart JS -->
<script src="assets/plugins/apexchart/apexcharts.min.js"></script>
<script src="assets/plugins/apexchart/chart-data.js"></script>	