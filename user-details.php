<?php 
    include 'config.php';
    if(in_array($yourIP, $ipArray)) {
        if ($hasAdminRights) {
            if (isset($_SESSION['as_user'])) {
                $usersActive = 'active';   
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>User Details</title>
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
							<h4>USER_NAME</h4>
						</div>
					</div>
					<!-- /add -->
					<div class="row">
						<div class="col-md-6">
							<div class="card">
								<div class="card-body">
                                    <img src="assets/img/product/product69.jpg" alt="img">
									<div class="productdetails">
										<ul class="product-bar">
											<li>
												<h4>Product</h4>
												<h6>Macbook pro	</h6>
											</li>
											<li>
												<h4>Category</h4>
												<h6>Computers</h6>
											</li>
											<li>
												<h4>Sub Category</h4>
												<h6>None</h6>
											</li>
											<li>
												<h4>Brand</h4>
												<h6>None</h6>
											</li>
											<li>
												<h4>Unit</h4>
												<h6>Piece</h6>
											</li>
											<li>
												<h4>SKU</h4>
												<h6>PT0001</h6>
											</li>
											<li>
												<h4>Minimum Qty</h4>
												<h6>5</h6>
											</li>
											<li>
												<h4>Quantity</h4>
												<h6>50</h6>
											</li>
											<li>
												<h4>Tax</h4>
												<h6>0.00 %</h6>
											</li>
											<li>
												<h4>Discount Type</h4>
												<h6>Percentage</h6>
											</li>
											<li>
												<h4>Price</h4>
												<h6>1500.00</h6>
											</li>
											<li>
												<h4>Status</h4>
												<h6>Active</h6>
											</li>
											<li>
												<h4>Description</h4>
												<h6>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,</h6>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="card">
								<div class="card-body">
                                    <h4><strong>Emergency Contact Information 1</strong></h4>
                                    <form class="row" method="post">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="text" name="ipAddress" value="">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label>Relation</label>
                                                <input type="text" name="ipAddress" value="">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label>Contact</label>
                                                <input type="text" name="ipAddress" value="">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <button type="submit" name="add" class="btn btn-submit me-2">Add Contact</button>
                                        </div>
                                    </form>
								</div>
							</div>
							<div class="card">
								<div class="card-body">
                                    <h4><strong>Emergency Contact Information 2</strong></h4>
                                    <form class="row" method="post">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="text" name="ipAddress" value="">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label>Relation</label>
                                                <input type="text" name="ipAddress" value="">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label>Contact</label>
                                                <input type="text" name="ipAddress" value="">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <button type="submit" name="add" class="btn btn-submit me-2">Add Contact</button>
                                        </div>
                                    </form>
								</div>
							</div>
						</div>
					</div>
						
					<!-- /add -->
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
            text: "This User will be permanently deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#FF9F43',
            cancelButtonColor: '#f5365c', 
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = "code.php?type=deleteUser&userId=" + id;
            }
        });
    });
</script>
