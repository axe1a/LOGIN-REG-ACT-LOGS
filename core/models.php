<?php  

require_once 'dbConfig.php';

function getAllNurse($pdo) {
	$sql = "SELECT * FROM nurse 
			ORDER BY first_name ASC";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute();
	if ($executeQuery) {
		return $stmt->fetchAll();
	}
}

function getNurseByID($pdo, $nurse_id) {
	$sql = "SELECT * FROM nurse WHERE nurse_id = ?";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$nurse_id]);

	if ($executeQuery) {
		return $stmt->fetch();
	}
}

function searchForANurse($pdo, $searched_by, $searchQuery) {
	
	$sql = "SELECT * FROM nurse WHERE 
			CONCAT(first_name, last_name, email, gender,
				home_address, date_of_birth, nationality, salary, date_added) 
			LIKE ?";

	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute(["%".$searchQuery."%"]);
	if ($executeQuery) {
		insertAuditLog($pdo, $searched_by, 'Search', 'Nurse',  'N/A', 'Searched for a Nurse');
		return $stmt->fetchAll();
	}
}



function insertNewNurse($pdo, $first_name, $last_name, $email, 
	$gender, $home_address, $date_of_birth, $nationality, $salary, $added_by, $user_id) {

	$sql = "INSERT INTO nurse 
			(
				first_name,
				last_name,
				email,
				gender,
				home_address,
				date_of_birth,
				nationality,
				salary,
				added_by,
				user_id
			)
			VALUES (?,?,?,?,?,?,?,?,?,?)
			";

	$stmt = $pdo->prepare($sql);
	
	$executeQuery = $stmt->execute([
		$first_name, $last_name, $email, 
		$gender, $home_address, $date_of_birth, 
		$nationality, $salary, $added_by, $user_id
	]);

	if ($executeQuery) {
		$update_id = $pdo->lastInsertId();
		insertAuditLog($pdo, $added_by, 'Insert', 'Nurse', $update_id, 'Added a Nurse');
		return ['message' => "Data successfully inserted.",
				'statusCode' => 200];
	}
	else {
		return ['message' => "Failed to insert data.",
				'statusCode' => 400];
	}

}



function editNurse($pdo, $first_name, $last_name, $email, $gender, 
	$home_address, $date_of_birth, $nationality, $salary, $last_updated_by, $nurse_id) {

	$sql = "UPDATE nurse
				SET first_name = ?,
					last_name = ?,
					email = ?,
					gender = ?,
					home_address = ?,
					date_of_birth = ?,
					nationality = ?,
					salary = ?,
					last_updated_by = ?
				WHERE nurse_id = ? 
			";

	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$first_name, $last_name, $email, $gender, 
		$home_address, $date_of_birth, $nationality, $salary, $last_updated_by, $nurse_id]);

		if ($executeQuery) {

			insertAuditLog($pdo, $last_updated_by, 'Update', 'Nurse', $nurse_id, 'Updated a Nurse');
			return ['message' => "Data successfully edited.",
					'statusCode' => 200];
		}
		else {
			return ['message' => "Failed to edit data.",
					'statusCode' => 400];
		}

}


function deleteNurse($pdo, $deleted_by, $nurse_id) {
	$sql = "DELETE FROM nurse 
			WHERE nurse_id = ?";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$nurse_id]);

	if ($executeQuery) {

		insertAuditLog($pdo, $deleted_by, 'Delete', 'Nurse', $nurse_id, 'Deleted a Nurse');
		return ['message' => "Data successfully deleted.",
				'statusCode' => 200];
	}
	else {
		return ['message' => "Failed to delete data.",
				'statusCode' => 400];
	}
}

function insertNewUser($pdo, $username, $first_name, $last_name, $password) {

	$checkUserSql = "SELECT * FROM user_db WHERE username = ?";
	$checkUserSqlStmt = $pdo->prepare($checkUserSql);
	$checkUserSqlStmt->execute([$username]);

	if ($checkUserSqlStmt->rowCount() == 0) {

		$sql = "INSERT INTO user_db (username, first_name, last_name, password) VALUES(?,?,?,?)";
		$stmt = $pdo->prepare($sql);
		$executeQuery = $stmt->execute([$username, $first_name, $last_name, $password]);

		if ($executeQuery) {
			$_SESSION['message'] = "User successfully inserted";
			return true;
		}

		else {
			$_SESSION['message'] = "An error occured from the query";
		}

	}
	else {
		$_SESSION['message'] = "User already exists";
	}

	
}



function loginUser($pdo, $username, $password) {
	$sql = "SELECT * FROM user_db WHERE username=?";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$username]); 

	if ($stmt->rowCount() == 1) {
		$userInfoRow = $stmt->fetch();
		$userIDFromDB = $userInfoRow['user_id']; 
		$usernameFromDB = $userInfoRow['username']; 
		$passwordFromDB = $userInfoRow['password'];

		if ($password == $passwordFromDB) {
			$_SESSION['user_id'] = $userIDFromDB;
			$_SESSION['username'] = $usernameFromDB;
			return true;
		}

		else {
			$_SESSION['message'] = "Password is invalid, but user exists";
		}
	}

	
	if ($stmt->rowCount() == 0) {
		$_SESSION['message'] = "Username doesn't exist.";
	}

}


function getAllUsers($pdo) {
	$sql = "SELECT * FROM user_db";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute();

	if ($executeQuery) {
		return $stmt->fetchAll();
	}

}

function getUserByID($pdo, $user_id) {
	$sql = "SELECT * FROM user_db WHERE user_id = ?";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$user_id]);
	if ($executeQuery) {
		return $stmt->fetch();
	}
}

function updateUserInfo($pdo, $first_name, $last_name, $user_id) {
	$sql = "UPDATE user_db 
			SET first_name = ?, 
				last_name = ? 
			WHERE user_id = ?";
	$stmt = $pdo->prepare($sql);

	if ($stmt) {
		return $stmt->execute([$first_name, $last_name, $user_id]);
	}


}

function insertAuditLog($pdo, $username, $action, $table_name, $update_id, $action_details)
{
  $sql = "INSERT INTO audit_log (username, action, table_name, update_id, action_details) VALUES (?, ?, ?, ?, ?)";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$username, $action, $table_name, $update_id, $action_details]);
}

function getAllAuditLog($pdo)
{
  $sql = "SELECT * FROM audit_log";
  $stmt = $pdo->prepare($sql);
  $executeQuery = $stmt->execute();

  if ($executeQuery) {
    return $stmt->fetchAll();
  }

}