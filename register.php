<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <?php
    /*Following code is referenced from https://www.tutorialrepublic.com/php-tutorial/php-mysql-login-system.php*/
    /* 
    
    CREATE TABLE users (
    id INT NOT NULL AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    primary key (id, username)
    )engine = InnoDB default character set = utf8 collate = utf8_general_ci;


    CREATE TABLE user_stories (
    id INT NOT NULL,
    username VARCHAR(50) NOT NULL,
    story_id INT NOT NULL AUTO_INCREMENT,
    story_title VARCHAR(1023) NOT NULL,
    story_content LONGTEXT NOT NULL,
    story_link TEXT NOT NULL,
    story_time DATETIME DEFAULT CURRENT_TIMESTAMP,
    story_upvote INT NOT NULL,
    story_downvote INT NOT NULL,
    primary key (story_id),
    foreign key (id, username) references users (id, username)
    )engine = InnoDB default character set = utf8 collate = utf8_general_ci;


    CREATE TABLE user_comments (
    id INT NOT NULL,
    username VARCHAR(50) NOT NULL,
    comment_id INT NOT NULL AUTO_INCREMENT,
    comment_story INT NOT NULL,
    comment_time DATETIME DEFAULT CURRENT_TIMESTAMP,
    comment_content LONGTEXT NOT NULL,
    comment_upvote INT NOT NULL,
    comment_downvote INT NOT NULL,
    primary key (comment_id),
    foreign key (id, username, comment_story) references user_stories (id, username, story_id)
    )engine = InnoDB default character set = utf8 collate = utf8_general_ci;

    */

    //start session and connect to database
    session_start();
    require 'connectdatabase.php';
    $username_err = $password_err = $confirm_password_err = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //get new username
        if (empty(trim($_POST["new_username"]))) {
            $username_err = "Please input a valid username.";
        } else if (!preg_match('/^[\w_\.\-]+$/', $_POST["new_username"])) {
            $username_err = "Invalid username. Please only use letters, numbers, and underscores.";
        } else {
            $new_username = trim($_POST["new_username"]);

            //check for duplicate username
            //referenced from https://stackoverflow.com/questions/5378427/php-mysql-check-for-duplicate-entry
            $duplicate_select = $mysqli->query("SELECT * FROM users WHERE username = '$new_username'");
            $num_rows = mysqli_num_rows($duplicate_select);
            if ($num_rows){
                $username_err = "This username is already taken.";
            }
        }

        //get new password
        if (empty(trim($_POST["new_password"]))) {
            $password_err = "Please input a password.";
        } else {
            $new_password = trim($_POST["new_password"]);
        }

        //ask to confirm new password
        if (empty(trim($_POST["confirm_password"]))) {
            $confirm_password_err = "Please confirm your password.";
        } else {
            $confirm_password = trim($_POST["confirm_password"]);
            if ($new_password != $confirm_password) {
                $confirm_password_err = "Password did not match.";
            }
        }

        //confirm there are no signup errors before entering into database
        if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
            //hash password
            $password_hash = password_hash($new_password, PASSWORD_DEFAULT);

            $stmt = $mysqli->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            if (!$stmt) {
                printf("Query Prep Failed: %s\n", $mysqli->error);
                exit;
            }

            $stmt->bind_param('ss', $new_username, $password_hash);

            $stmt->execute();

            $stmt->close();

            echo "You have been registered. You will be returned to login.";
            header("Refresh:5; url=login.php");
        }
    }
    ?>


    <div class="register">
        <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
            <p class="maintitle">Register</p>
            <div>
                <label> New Username: <input type="text" id="username" name="new_username"></label>
            </div>

            <div>
                <label> New Password: <input type="text" id="password" name="new_password"></label>
            </div>

            <div>
                <label> Confirm Password: <input type="text" id="confirm_password" name="confirm_password"></label>
            </div>


            <input type="submit" value="Sign Up" /> <br>

            <?php
            if (!empty($username_err)) {
                echo $username_err;
            } else if (!empty($password_err)) {
                echo $password_err;
            } else {
                echo $confirm_password_err;
            }
            ?>

        </form>
    </div>

</body>

</html>