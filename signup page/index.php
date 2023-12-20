<?php 

	require 'functions.php';

	if(!is_logged_in())
	{
		redirect('login.php');
	}

	$id = $_GET['id'] ?? $_SESSION['PROFILE']['id'];

	$row = db_query("select * from users where id = :id limit 1",['id'=>$id]);

	if($row)
	{
		$row = $row[0];
	}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Profile</title>
	<link rel="icon" type="image/x-icon" href="./images/logo.svg">
	<link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="./css/bootstrap-icons.css">
	
</head>
<body>

	<?php if(!empty($row)):?>
		
		
		<div class="row col-lg-8 border rounded mx-auto mt-5 p-2 shadow-lg">
			<div class="col-md-4 text-center">
			<br>
			<div class="h2">User Profile</div>
			<br>
				<img src="<?=get_image($row['image'])?>" class="img-fluid rounded" style="width: 180px;height:180px;object-fit: cover;">
				
				<div style="font-size: 0;">

					<?php if(user('id') == $row['id']):?>
						<p></p>
						<a href="profile-edit.php">
							<button class="mx-auto m-1 btn-sm btn btn-primary">Edit</button>
						</a>
						
						<a href="profile-delete.php" style="margin-left: 20px;">
							<button class="mx-auto m-1 btn-sm btn btn-warning text-white">Delete</button>
						</a>
						
					<?php endif;?>
				</div>
			</div>
			<div class="col-md-8">
				<br>
			<a href="logout.php" style="text-align: right; display: block;">
    			<button class="mx-auto m-1 btn-sm btn btn-info text-white">Logout</button>
			</a>
<br>
				
			<table class="table table-striped">
				<tr><th colspan="2">User Details:</th></tr>
				<tr><th><i class="bi bi-envelope"></i> Email</th><td><?= esc($row['email']) ?></td></tr>
				<tr><th><i class="bi bi-person-circle"></i> Name</th><td><?= esc($row['firstname']) ?></td></tr>
				<tr><th><i class="bi bi-phone"></i> Contact</th><td><?= esc($row['contact']) ?></td></tr>
				<tr><th><i class="bi bi-gender-ambiguous"></i> Gender</th><td><?= esc($row['gender']) ?></td></tr>
				<tr><th><i class="bi bi-person"></i> Age</th><td><?= esc($row['age']) ?></td></tr>
				<tr><th><i class="bi bi-calendar"></i> Date of Birth</th><td><?= esc($row['dob']) ?></td></tr>
			</table>

				<br>
			</div>
			
		</div>
			

					
	<?php else:?>
		<div class="text-center alert alert-danger">That profile was not found</div>
		<a href="index.php">
			<button class="btn btn-primary m-4">Home</button>
		</a>
	<?php endif;?>

</body>
</html>