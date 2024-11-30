<?php 
session_start();
require_once 'core/dbConfig.php'; 
require_once 'core/models.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>RestWell Nurse Database - Registered Users</title>
	<link rel="stylesheet" href="styles.css">
	<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>
<body>
	<form action="userlist.php" method="GET">
		<input type="text" name="searchInput" placeholder="Search here">
		<input type="submit" name="searchBtn">
	</form>

	<?php $getAllUsers = getAllUsers($pdo); ?>
	<h1>Users List</h1>
	<p><a href="index.php">Return to Home</a></p>
    <table>
            <tr>
                <th>User ID</th>
				<th>Username</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Date Added</th>
                				
            </tr>

            <?php foreach ($getAllUsers as $row) { ?>
            <tr>
                <td><?php echo $row['user_id']; ?></td>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['first_name']; ?></td>
                <td><?php echo $row['last_name']; ?></td>
                <td><?php echo $row['date_added']; ?></td>
                </tr>
            <?php } ?>
    </table>
	</div>
</body>
</html>