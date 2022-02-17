<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        require 'connectdatabase.php';
        session_start();
        //get story_id
        $username = $_SESSION['user_id']; 
        $story_id = $_POST['story_id'];

        if(!hash_equals($_SESSION['token'], $_POST['token'])){
            die("Request forgery detected for delete story");
        }
    
        if (empty($_SESSION['user_id'])) {
            header('Location: account.php');
            exit;
        }

        //delete story
        $stmt = $mysqli->prepare("DELETE FROM user_stories WHERE story_id = ? and username = ?");
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $stmt->bind_param('is', $story_id, $username);
        $stmt->execute();
        $stmt->close();

        //delete all comments associated with story
        $stmt2 = $mysqli->prepare("DELETE FROM user_comments WHERE comment_story = ?");
        if(!$stmt2){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $stmt2->bind_param('i', $story_id);
        $stmt2->execute();
        $stmt2->close();

        header('Location: account.php');
    ?>
</body>
</html>