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

        //delete story
        $stmt = $mysqli->prepare("DELETE FROM user_stories WHERE story_id = ? and username = ?");
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $stmt->bind_param('is', $story_id, $username);
        $stmt->execute();
        $stmt->close();
        header('Location: account.php');
        //delete all comments associated with story
        


    ?>
</body>
</html>