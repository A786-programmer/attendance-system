<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="<?= $indexActive ?>">
                    <a href="index.php" ><img src="assets/img/icons/dashboard.svg" alt="img"><span>Dashboard</span></a>
                </li>
                <?php if ($hasAdminRights) { ?>
                <li class="submenu">
                    <a href="javascript:void(0)"><img src="assets/img/icons/time.svg" alt="img"><span>Attendance</span><span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="add-attendance.php" class="<?= $addAttendanceActive ?>"> Add </a></li>
                        <li><a href="fetch-attendance.php" class="<?= $fetchAttendanceActive ?>"> Fetch </a></li>
                    </ul>
                </li>
                <li class="<?= $usersActive ?>">
                    <a href="users.php"><img src="assets/img/icons/users1.svg" alt="img"><span>Users</span></a>
                </li>
                <li class="<?= $ipActive ?>">
                    <a href="ip-address.php"><i data-feather="bar-chart-2"></i><span>IP Addresses</span></a>
                </li>
                <li class="<?= $notificationsActive ?>">
                    <a href="notifications.php"><img src="assets/img/icons/purchase1.svg" alt="img"><span>Notifications</span></a>
                </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar -->