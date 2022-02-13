<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body class="center">
    <?php
    //start session and database
    session_start();
    require 'connectdatabase.php';
    $username_err = $password_err = $login_err = "";

    //get input username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please input a username.";
    }
    //get input password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please input a password.";
    }

    // Use a prepared statement
    $stmt = $mysqli->prepare("SELECT COUNT(*), username, password FROM users WHERE username=?");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    
    // Bind the parameter
    $stmt->bind_param('s', $user);
    $user = $_POST['username'];
    $stmt->execute();
    
    // Bind the results
    $stmt->bind_result($cnt, $username, $pwd_hash);
    $stmt->fetch();
    
    $pwd_guess = $_POST['password'];

    // Compare the submitted password to the actual password hash
    if($cnt == 1 && password_verify($pwd_guess, $pwd_hash)){
        // Login succeeded!
        $_SESSION['user_id'] = $user_id;
        header("Location: homepage.php");
    } else{
        // Login failed; redirect back to the login screen
        $login_err = "This username or password is invalid.";
    }
    ?>

    <!-- HTML Form -->
    <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
        <div class="login">
            <p class="maintitle"> Login </p>
            <div>
                <label> Username: <input type="text" id="username" name="username"></label>
            </div>

            <div>
                <label> Password: <input type="text" id="password" name="password"></label>
            </div>

            <input type="submit" value="Log In" /> <br>


            <?php
            if (!empty($username_err)) {
                echo $username_err;
            } else if (!empty($password_err)) {
                echo $password_err;
            } else {
                echo $login_err;
            }
            ?>
            <p> Don't have a username? <a href="register.php">Sign up here</a></p>
        </div>


    </form>

</body>

</html>