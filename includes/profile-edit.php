<?php

	//validate firstname
	if (empty($_POST['firstname'])) {
		$info['errors']['firstname'] = "A first name is required";
	} else if (!preg_match("/^[\p{L}\s]+$/u", $_POST['firstname'])) {
		$info['errors']['firstname'] = "First name can't have special characters or numbers";
	}
	
	// Validate mobile number
	if (empty($_POST['contact'])) {
		$info['errors']['contact'] = "A mobile number is required";
	} else if (!preg_match("/^\d+$/", $_POST['contact'])) {
		$info['errors']['contact'] = "Mobile number should only contain digits";
	}

	//validate email
	if(empty($_POST['email']))
	{
		$info['errors']['email'] = "An email is required";
	}else
	if(!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
	{
		$info['errors']['email'] = "Email is not valid";
	}

	//validate gender
	$genders = ['Male','Female'];
	if(empty($_POST['gender']))
	{
		$info['errors']['gender'] = "A gender is required";
	}else
	if(!in_array($_POST['gender'], $genders))
	{
		$info['errors']['gender'] = "Gender is not valid";
	}

	//validate password
	if(!empty($_POST['password']))
	{
	
		if($_POST['password'] !== $_POST['retype_password'])
		{
			$info['errors']['password'] = "Passwords dont match";
		}else
		if(strlen($_POST['password']) < 8)
		{
			$info['errors']['password'] = "Password must be at least 8 characters long";
		}
	}

	if (empty($_POST['age'])) {
		$info['errors']['age'] = "Age is required";
	} else if (!preg_match("/^\d+$/", $_POST['age'])) {
		$info['errors']['age'] = "Age should be digits";
	}

	if(!empty($_FILES['image']['name']))
	{
		$folder = "uploads/";
		if(!file_exists($folder))
		{
			mkdir($folder, 0777, true);
			file_put_contents($folder.'index.html', 'Access denied');
		}

		$allowed = ['image/jpeg','image/png'];
		if(in_array($_FILES['image']['type'], $allowed))
		{
			$image = $folder . time() . $_FILES['image']['name'];
			move_uploaded_file($_FILES['image']['tmp_name'], $image);

		}else{
			$info['errors']['image'] = "Only images of this type allowed: ".implode(", ", $allowed);
		}
	}


	if(empty($info['errors']) && $row)
	{
		//save to database
		$arr = [];
		$arr['firstname'] 	= $_POST['firstname'];
		$arr['contact'] 	= $_POST['contact'];
		$arr['age'] 		= $_POST['age'];
		$arr['email'] 		= $_POST['email'];
		$arr['gender'] 		= $_POST['gender'];
		$arr['dob'] 		= $_POST['dob'];
		$arr['id'] 			= $row['id'];

		$image_query = "";
		if(!empty($image))
		{
			$arr['image'] = $image;
			$image_query = ",image = :image";
		}

		$password_query = "";
		if(!empty($_POST['password']))
		{
			$arr['password'] 	= password_hash($_POST['password'], PASSWORD_DEFAULT);
			$password_query = ",password = :password";
		}
 
		db_query("update users set firstname = :firstname,contact = :contact,age = :age,gender = :gender,dob = :dob,email = :email $image_query $password_query where id = :id limit 1",$arr);

		//delete old image
		if(!empty($image) && file_exists($row['image']))
		{
			unlink($row['image']);
		}

		$row = db_query("select * from users where id = :id limit 1",['id'=>$row['id']]);
		if($row)
		{
			$row = $row[0];
			$_SESSION['PROFILE'] = $row;
		}

		$info['success'] 	= true;

		
	}
