<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Comment</title>
</head>

<body>
    <?php
    require 'connectdatabase.php';
    session_start();
    //get story_id
    $username = $_SESSION['user_id'];
    $comment_id = $_POST['comment_id'];

    if(!hash_equals($_SESSION['token'], $_POST['token'])){
        die("Request forgery detected for delete comment");
    }

    if (empty($_SESSION['user_id'])) {
        header('Location: account.php');
        exit;
    }

    //delete story
    $stmt = $mysqli->prepare("DELETE FROM user_comments WHERE comment_id = ? and username = ?");
    if (!$stmt) {
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('is', $comment_id, $username);
    $stmt->execute();
    $stmt->close();
    
    header('Location: account.php');
    ?>
</body>

</html>