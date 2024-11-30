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
	<title>RestWell Nurse Database - Audit Log</title>
	<link rel="stylesheet" href="styles.css">
	<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>
<body>
	<form action="auditlog.php" method="GET">
		<input type="text" name="searchInput" placeholder="Search here">
		<input type="submit" name="searchBtn">
	</form>

	<?php $getAllAuditLog = getAllAuditLog($pdo); ?>
	<h1>Audit Log</h1>
	<p><a href="index.php">Return to Home</a></p>
	<table>
            <tr>
                <th>Attribute ID</th>
				<th>Username</th>
                <th>Action</th>
                <th>Table</th>
                <th>Details</th>
                <th>Time</th>				
            </tr>

            <?php foreach ($getAllAuditLog as $row) { ?>
            <tr>
                <td><?php echo $row['update_id']; ?></td>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['action']; ?></td>
                <td><?php echo $row['table_name']; ?></td>
                <td><?php echo $row['action_details']; ?></td>
                <td><?php echo $row['action_timestamp']; ?></td>
				<?php } ?>
			</tr>
    </table>			

    
	</div>
</body>
</html>