<div class="header">		
    <div class="header-left active">
        <a href="index.php" class="logo"><img src="assets/img/logo.png" alt=""></a>
        <a href="index.php" class="logo-small"><img src="assets/img/logo-small.png" alt=""></a>
        <a id="toggle_btn" href="javascript:void(0);"></a>
    </div>
    <a id="mobile_btn" class="mobile_btn" href="#sidebar">
        <span class="bar-icon">
            <span></span>
            <span></span>
            <span></span>
        </span>
    </a> 

    <?php
        // ✅ Use a unique variable name to avoid conflict with user-details.php
        $loggedInUserId = $_SESSION['as_user'] ?? 0;
        $loggedInUserQuery = mysqli_query($con, "SELECT * FROM users WHERE u_id='$loggedInUserId'");
        $loggedInUser = mysqli_fetch_assoc($loggedInUserQuery);

        $placeholderImg = 'assets/img/user.png';

        if (!empty($loggedInUser['u_profile_img']) && file_exists('user-profile-imgs/'.$loggedInUser['u_profile_img'])) {
            $profileImg = 'user-profile-imgs/'.$loggedInUser['u_profile_img'];
        } else {
            $profileImg = $placeholderImg;
        }

        $role = $loggedInUser['u_role'] ?? 'User';
    ?>

    <ul class="nav user-menu">        
        <li class="nav-item dropdown has-arrow main-drop">
            <a href="javascript:void(0);" class="dropdown-toggle nav-link userset" data-bs-toggle="dropdown">
                <span class="user-img">
                    <img src="<?= htmlspecialchars($profileImg); ?>" alt="Profile Image">
                    <span class="status online"></span>
                </span>
            </a>
            <div class="dropdown-menu menu-drop-user">
                <div class="profilename">
                    <div class="profileset">
                        <span class="user-img">
                            <img src="<?= htmlspecialchars($profileImg); ?>" alt="Profile Image">
                            <span class="status online"></span>
                        </span>
                        <div class="profilesets">
                            <h6><?= htmlspecialchars($loggedInUser['u_name']); ?></h6>
                            <h5><?= htmlspecialchars($role); ?></h5>
                        </div>
                    </div>
                    <hr class="m-0">
                    <a class="dropdown-item" href="settings.php">
                        <i class="me-2" data-feather="settings"></i>Settings
                    </a>
                    <hr class="m-0">
                    <a class="dropdown-item logout pb-0" href="code.php?type=logout">
                        <img src="assets/img/icons/log-out.svg" class="me-2" alt="img">Logout
                    </a>
                </div>
            </div>
        </li>
    </ul>

    <div class="dropdown mobile-user-menu">
        <a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa fa-ellipsis-v"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="settings.php">Settings</a>
            <a class="dropdown-item" href="code.php?type=logout">Logout</a>
        </div>
    </div>
</div>
