<?php 
require_once 'core/handleForms.php';
require_once 'core/models.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>RestWell Nurse Database - Insert</title>
	<link rel="stylesheet" href="styles.css">
</head>
<body>
	
	
	<form action="core/handleForms.php" method="POST">
		<h2>Insert a Nurse's Information</h2>
		<br>
		<p>
			<label for="firstName">First Name</label> 
			<input type="text" name="first_name">
		</p>
		<p>
			<label for="firstName">Last Name</label> 
			<input type="text" name="last_name">
		</p>
		<p>
			<label for="firstName">Email</label> 
			<input type="text" name="email">
		</p>
		<p>
			<label for="firstName">Gender</label> 
			<input type="text" name="gender">
		</p>
		<p>
			<label for="firstName">Home Address</label> 
			<input type="text" name="home_address">
		</p>
		<p>
			<label for="firstName">Date of Birth</label> 
			<input type="text" name="date_of_birth">
		</p>
		<p>
			<label for="firstName">Nationality</label> 
			<input type="text" name="nationality">
		</p>
		<p>
			<label for="firstName">Salary</label> 
			<input type="text" name="salary">
		</p>
		<p>
			<input type="submit" name="insertNurseBtn">
			<p><a href="index.php">Return to Home</a></p>
		</p>
	</form>
</body>
</html>