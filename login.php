<?php 
    include 'config.php';
    if (!isset($_SESSION['as_user'])) {
        if (isset($_POST['login'])) {
            try {
                $email = $_POST['email'];
                $password = $_POST['password'];
                $user = mysqli_query($con,"SELECT * FROM `users` WHERE u_email='$email' AND u_password='$password'");

                if (mysqli_num_rows($user)) {
                    $fetchUser = mysqli_fetch_assoc($user);
                    if ($fetchUser['u_status'] == 0) {
                        $_SESSION['toastr_message'] = "Your Account has been Disabled by Admin!";
                        $_SESSION['toastr_type'] = "error";       
                        header("Location: login.php");
                        exit();
                    }
                    $_SESSION['as_user'] = $fetchUser['u_id'];
                    header("Location: settings.php");
                    exit();
                }
                $_SESSION['toastr_message'] = "Invalid Credentials!";
                $_SESSION['toastr_type'] = "error";
                header("Location: login.php");
                exit();
			} catch(Exception $e) {
				$_SESSION['toastr_message'] = "Something went wrong: " . $e->getMessage();
				$_SESSION['toastr_type'] = "error";
				header("Location: login.php");
				exit();
			}
		}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Login | <?= $websiteName ?></title>
        <?php include 'header-files.php' ?>
    </head>
    <body class="account-page">
		<!-- Main Wrapper -->
        <div class="main-wrapper">
			<div class="account-content">
				<div class="login-wrapper">
                    <div class="login-content">
                        <form class="login-userset" method="post">
                            <div class="login-userheading">
                                <h3>May Your Day be Happy Ahead!</h3>
                                <h4>Please login to your account</h4>
                            </div>
                           <div class="form-login">
                                <label>Email</label>
                                <div class="form-addons">
                                    <input required type="email" name="email" placeholder="Enter your email address">
                                    <img src="assets/img/icons/mail.svg" alt="img">
                                </div>
                            </div>
                            <div class="form-login">
                                <label>Password</label>
                                <div class="pass-group">
                                    <input required type="password" name="password" class="pass-input" placeholder="Enter your password">
                                    <span class="fas toggle-password fa-eye-slash"></span>
                                </div>
                            </div>
                            <div class="form-login">
                                <button class="btn btn-login" type="submit" name="login">Login</button>
                            </div>
                        </form>
                    </div>
                    <div class="login-img">
                        <img src="assets/img/login.jpg" alt="img">
                    </div>
                </div>
			</div>
        </div>
    </body>
</html>
<?php 
    } else {
        $_SESSION['toastr_message'] = "You are already logged in!";
        $_SESSION['toastr_type'] = "info";
        header("Location: index.php");
        exit();
    }
    include 'footer-files.php';
?>