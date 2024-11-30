<?php  
session_start();
require_once 'dbConfig.php';
require_once 'models.php';
require_once 'validate.php';

if (isset($_POST['insertNurseBtn'])) {

	$added_by = $_SESSION['username'];
	$user_id = $_SESSION['user_id'];

	$first_name = sanitizeInput($_POST['first_name']);
	$last_name = sanitizeInput($_POST['last_name']);
	$email = sanitizeInput($_POST['email']);
	$home_address = sanitizeInput($_POST['home_address']);
	$date_of_birth = sanitizeInput($_POST['date_of_birth']);
	$nationality = sanitizeInput($_POST['nationality']);
	$salary = sanitizeInput($_POST['salary']);

    $insertNurse = insertNewNurse($pdo, $_POST['first_name'], $_POST['last_name'], $_POST['email'], 
        $_POST['gender'], $_POST['home_address'], $_POST['date_of_birth'], 
        $_POST['nationality'], $_POST['salary'], $added_by, $user_id);

    if ($insertNurse['statusCode'] === 200) { 
		$_SESSION['message'] = $insertTeacher['message'];
		header("Location: ../index.php");
	}
	else { 
		$_SESSION['message'] = $insertNurse['message'];
	}
}

if (isset($_POST['editNurseBtn'])) {

	$last_updated_by = $_SESSION['username'];
	$user_id = $_SESSION['user_id'];

	$first_name = sanitizeInput($_POST['first_name']);
	$last_name = sanitizeInput($_POST['last_name']);
	$email = sanitizeInput($_POST['email']);
	$home_address = sanitizeInput($_POST['home_address']);
	$date_of_birth = sanitizeInput($_POST['date_of_birth']);
	$nationality = sanitizeInput($_POST['nationality']);
	$salary = sanitizeInput($_POST['salary']);
	
    $editNurse = editNurse($pdo, $_POST['first_name'], $_POST['last_name'], 
        $_POST['email'], $_POST['gender'], $_POST['home_address'], 
        $_POST['date_of_birth'], $_POST['nationality'], $_POST['salary'], 
        $last_updated_by, $_GET['nurse_id']);

    if ($editNurse['statusCode'] === 200) { 
		$_SESSION['message'] = $editNurse['message'];
		header("Location: ../index.php");
	}
	else { 
		$_SESSION['message'] = $editNurse['message'];
	}
}

if (isset($_POST['deleteNurseBtn'])) {

	$deleted_by = $_SESSION['username'];
	$user_id = $_SESSION['user_id'];

    $deleteNurse = deleteNurse($pdo, $deleted_by, $_GET['nurse_id']);

    if ($deleteNurse['statusCode'] === 200) { 
		$_SESSION['message'] = $deleteNurse['message'];
		header("Location: ../index.php");
	}
	else { 
		$_SESSION['message'] = $deleteNurse['message'];
	}
}

if (isset($_GET['searchBtn'])) {

	$searched_by = $_SESSION['username'];
	$user_id = $_SESSION['user_id'];

	if (isset($_SESSION['username'])) {
        $searched_by = $_SESSION['username'];
    } else {
        $searched_by = '';  // If session variable is not set, set a fallback
    }

	var_dump($searched_by);

	$searchInput = sanitizeInput($_GET['searchInput']);

	$searchForAUser = searchForANurse($pdo, $searched_by, $_GET['searchInput']);
	foreach ($searchForANurse as $row) {
		echo "<tr> 
				<td>{$row['nurse_id']}</td>
				<td>{$row['first_name']}</td>
				<td>{$row['last_name']}</td>
				<td>{$row['email']}</td>
				<td>{$row['gender']}</td>
				<td>{$row['home_address']}</td>
				<td>{$row['date_of_birth']}</td>
				<td>{$row['nationality']}</td>
				<td>{$row['salary']}</td>
			  </tr>";
	}
}

if (isset($_POST['registerUserBtn'])) {

	$username = sanitizeInput($_POST['username']);
	$first_name = sanitizeInput($_POST['first_name']);
	$last_name = sanitizeInput($_POST['last_name']);
	$password = $_POST['password'];
	$confirm_password = $_POST['confirm_password'];

	if (!empty($username) && !empty($first_name) && !empty($last_name) 
		&& !empty($password) && !empty($confirm_password)) {

		if ($password == $confirm_password) {

			if (validatePassword($password)) {

				$insertQuery = insertNewUser($pdo, $username, $first_name, $last_name, sha1($password));

				if ($insertQuery) {
					header("Location: ../login.php");
					exit; 
				} else {
					$_SESSION['message'] = "Registration failed. Please try again.";
					header("Location: ../register.php");
					exit;
				}
			} else {
				$_SESSION['message'] = "Password should contain more than 8 characters and contain both uppercase, lowercase, and numbers";
				header("Location: ../register.php");
				exit;
			}
		} else {
			$_SESSION['message'] = "Passwords are not the same!";
			header("Location: ../register.php");
			exit;
		}
	} else {
		$_SESSION['message'] = "Make sure the input fields are not empty.";
		header("Location: ../register.php");
		exit;
	}
}

if (isset($_POST['loginUserBtn'])) {

	$username = sanitizeInput($_POST['username']);
	$password = sha1($_POST['password']);

	if (!empty($username) && !empty($password)) {

		$loginQuery = loginUser($pdo, $username, $password);

		if ($loginQuery) {
			header("Location: ../index.php");
			exit;
		} else {
			$_SESSION['message'] = "Invalid username or password.";
			header("Location: ../login.php");
			exit;
		}
	} else {
		$_SESSION['message'] = "Please make sure the input fields are not empty for the login!";
		header("Location: ../login.php");
		exit;
	}
}

if (isset($_GET['logoutAUser'])) {
	unset($_SESSION['username']);
	header('Location: ../login.php');
	exit;
}

if (isset($_POST['editUserBtn'])) {
	$query = updateUserInfo($pdo, $_POST['first_name'], $_POST['last_name'], 
	 $_GET['user_id']);

	if ($query) {
		header("Location: ../index.php");
	}

	else {
		echo "Edit failed";;
	}

}