<?php 
    include 'config.php';
    if(in_array($yourIP, $ipArray)) {
        if ($hasAdminRights) {
            if (isset($_SESSION['as_user'])) {
                $ipActive = 'active';

                if (isset($_POST['add'])) {
                    try {
                        $ipAddress = $_POST['ipAddress'];
                        mysqli_query($con,"INSERT INTO ip_addresses(ia_address) VALUES ('$ipAddress')");
                        $_SESSION['toastr_message'] = "IP Address Has been Added Successfully!";
                        $_SESSION['toastr_type'] = "success";
                        header("Location: ip-address.php");
                        exit();
                    } catch (Exception $e) {
                        $_SESSION['toastr_message'] = "Something went wrong: " . $e->getMessage();
                        $_SESSION['toastr_type'] = "error";
                        header("Location: ip-address.php");
                        exit();
                    } 
                }   
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>IP Addresses</title>
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
							<h4>Add IP Address</h4>
						</div>
					</div>
					<div class="card">
						<div class="card-body">
							<form class="row" method="post">
								<div class="col-md-4">
									<div class="form-group">
										<label>IP Address</label>
										<input type="text" name="ipAddress" value="">
									</div>
								</div>
								<div class="col-lg-12">
									<button type="submit" name="add" class="btn btn-submit me-2">Add IP Address</button>
								</div>
                            </form>
						</div>
					</div>
                    <div class="page-header">
						<div class="page-title">
							<h4>IP Address List</h4>
						</div>
					</div>
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table datanew">
                                    <thead>
                                        <tr>
                                            <th>S. No</th>
                                            <th>IP Address</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $sno = 1;
                                            $ipAddressQuery = mysqli_query($con,"SELECT * FROM ip_addresses");
                                            while ($fetchIpAddress = mysqli_fetch_assoc($ipAddressQuery)) {
                                        ?>
                                        <tr>
                                            <td><?= $sno ?></td>
                                            <td><?= $fetchIpAddress['ia_address'] ?></td>
<td>
    <a href="javascript:void(0);" class="confirm-delete" data-id="<?= $fetchIpAddress['ia_id'] ?>">
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
            text: "This IP Address will be permanently deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#FF9F43',
            cancelButtonColor: '#f5365c',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = "code.php?type=deleteIpAddress&ipAddressId=" + id;
            }
        });
    });
</script>

