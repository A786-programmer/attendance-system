<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="<?= $indexActive ?>">
                    <a href="index.php" ><img src="assets/img/icons/dashboard.svg" alt="img"><span>Dashboard</span></a>
                </li>
                <?php if ($hasAdminRights) { ?>
                <li class="<?= $attendanceActive ?>">
                    <a href="attendance.php"><img src="assets/img/icons/time.svg" alt="img"><span>Attendance</span></a>
                </li>
                <li class="<?= $usersActive ?>">
                    <a href="users.php"><img src="assets/img/icons/users1.svg" alt="img"><span>Users</span></a>
                </li>
                <li class="<?= $usersActive ?>">
                    <a href="payroll.php"><img src="assets/img/icons/expense1.svg" alt="img"><span>Payroll</span></a>
                </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar -->