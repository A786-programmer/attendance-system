<?php 
	include 'config.php';
	if(in_array($yourIP, $ipArray)) {
		if (isset($_SESSION['as_user'])) {

			$userId = $_SESSION['as_user'];
			$userQuery = mysqli_query($con, "SELECT * FROM users WHERE u_id='$userId'");
			$fetchUser = mysqli_fetch_assoc($userQuery);

			if(isset($_POST['update'])){
				try {
					$userName = $_POST['userName'];
					$userEmail = $_POST['userEmail'];
					$userPassword = $_POST['userPassword'];
					$userProfile = $_FILES['userProfile']['name'];

					if ($userProfile) {
						move_uploaded_file($_FILES['userProfile']['tmp_name'], "user-profile-imgs/".$userProfile);
					} else {
						$userProfile = $fetchUser['u_profile_img'];
					}

					mysqli_query($con,"UPDATE users 
						SET u_name='$userName', 
							u_email='$userEmail', 
							u_password='$userPassword', 
							u_profile_img='$userProfile' 
						WHERE u_id='$userId'");

					$_SESSION['toastr_message'] = "Details Updated Successfully!";
					$_SESSION['toastr_type'] = "success";
					header("Location: settings.php");
					exit();
				} catch (Exception $e) {
					$_SESSION['toastr_message'] = "Something went wrong: " . $e->getMessage();
					$_SESSION['toastr_type'] = "error";
					header("Location: settings.php");
					exit();
				}
			}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Settings</title>
        <?php include 'header-files.php' ?>
	</head>
	<body>
		<div class="main-wrapper">
            <?php include 'header.php' ?>
            <?php include 'sidebar.php' ?>
			<div class="page-wrapper">
				<div class="content">
					<div class="page-header">
						<div class="page-title">
							<h4>Profile</h4>
							<h6>User Profile</h6>
						</div>
					</div>

					<!-- /product list -->
					<div class="card">
						<div class="card-body">

							<form method="post" enctype="multipart/form-data">

							<div class="profile-set">
								<div class="profile-head"></div>
								<div class="profile-top">
									<div class="profile-content">
										<div class="profile-contentimg">
											<img 
												src="<?= !empty($fetchUser['u_profile_img']) && file_exists('user-profile-imgs/'.$fetchUser['u_profile_img']) 
													? 'user-profile-imgs/'.$fetchUser['u_profile_img'] 
													: 'assets/img/user.png'; ?>" 
												alt="img" id="blah">

											<div class="profileupload">
												<input type="file" id="imgInp" name="userProfile" accept="image/*">
												<a href="javascript:void(0);"><img src="assets/img/icons/edit-set.svg" alt="img"></a>
											</div>
										</div>
										<div class="profile-contentname">
											<h2><?= htmlspecialchars($fetchUser['u_name']); ?></h2>
											<h4>Updates Your Photo and Personal Details.</h4>
										</div>
									</div>
									<!-- <div class="ms-auto">
										<button type="submit" name="update" class="btn btn-submit me-2">Save</button>
										<a href="settings.php" class="btn btn-cancel">Cancel</a>
									</div> -->
								</div>
							</div>

							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label>Full Name</label>
										<input type="text" name="userName" value="<?= htmlspecialchars($fetchUser['u_name']); ?>">
									</div>
								</div>

								<div class="col-lg-6">
									<div class="form-group">
										<label>Email</label>
										<input type="text" name="userEmail" value="<?= htmlspecialchars($fetchUser['u_email']); ?>">
									</div>
								</div>

								<div class="col-lg-6 col-sm-12">
									<div class="form-group">
										<label>Password</label>
										<div class="pass-group">
											<input type="password" name="userPassword" class="pass-input" value="<?= htmlspecialchars($fetchUser['u_password']); ?>" id="password">
										</div>
									</div>
								</div>

								<div class="col-12">
									<button type="submit" name="update" class="btn btn-submit me-2">Submit</button>
									<a href="settings.php" class="btn btn-cancel">Cancel</a>
								</div>
							</div>

							</form>
						</div>
					</div>
					<!-- /product list -->
				</div>
			</div>
		</div>	

		<script>
			// 🔸 Image Preview
			imgInp.onchange = evt => {
				const [file] = imgInp.files
				if (file) blah.src = URL.createObjectURL(file)
			}
		</script>
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
        echo 'Invalid IP Access. Your IP Address is '.$yourIP;
    }
	include 'footer-files.php';
?>
