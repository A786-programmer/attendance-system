<?php 
    include 'config.php';
    if (isset($_SESSION['as_user'])) {
        $indexActive = 'active'; 
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Home</title>
        <?php include 'header-files.php' ?>
        <link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css">
	</head>
	<body>
		<div class="main-wrapper">
            <?php include 'header.php' ?>
            <?php include 'sidebar.php' ?>
			<div class="page-wrapper">
				<div class="content">
                    
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
    include 'footer-files.php';
?>	
<!-- Datatable JS -->
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/dataTables.bootstrap4.min.js"></script>