<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete User</title>
</head>
<body>
<?php
        require 'connectdatabase.php';
        session_start();
        //get current user
        $username = $_SESSION['user_id'];

        if(!hash_equals($_SESSION['token'], $_POST['token'])){
            die("Request forgery detected for delete story");
        }
    
        if (empty($_SESSION['user_id'])) {
            header('Location: account.php');
            exit;
        }

        //delete all stories associated with user's account
        $stmt = $mysqli->prepare("DELETE FROM user_stories WHERE username = ?");
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->close();

        //delete all comments associated with user's account
        $stmt2 = $mysqli->prepare("DELETE FROM user_comments WHERE username = ?");
        if(!$stmt2){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $stmt2->bind_param('s', $username);
        $stmt2->execute();
        $stmt2->close();

        //delete user account itself
        $stmt3 = $mysqli->prepare("DELETE FROM users WHERE username = ?");
        if(!$stmt3){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $stmt3->bind_param('s', $username);
        $stmt3->execute();
        $stmt3->close();

        header('Location: login.php');
    ?>
</body>
</html>