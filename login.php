<?php  
require_once 'core/models.php'; 
require_once 'core/handleForms.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
	<title>RestWell Nurse Database - Login</title>
</head>
<body>
<div class="container-reg">
    <header>RestWell Nurse Database</header>
    
    <form action="core/handleForms.php" method="POST" class="login-form">
        <div class="form">
            <div class="details planner">
                <div class="inputAuth">
                    <label for="username">Username</label>
                    <input type="text" name="username" required>
                </div>

                <div class="inputAuth">
                    <label for="password">Password</label>
                    <input type="password" name="password" required>
                </div>
                
                <div class="button-container">
                    <input type="submit" name="loginUserBtn" value="Login">
                    <br><br>
                    <a href="register.php" class="register-link">Create new account</a>
                </div>
                
                <?php if (isset($_SESSION['message'])) { ?>
                <div class="message">        
                    <?php echo $_SESSION['message']; ?>
                </div>        
                <?php unset($_SESSION['message']); ?>
                <?php } ?>
            </div>
        </div>
    </form>
</div>
</body>
</html>