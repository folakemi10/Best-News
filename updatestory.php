<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Story</title>
</head>
<body>

<?php 
    require 'connectdatabase.php';
    session_start();

    if(!hash_equals($_SESSION['token'], $_POST['token'])){
        die("Request forgery detected for edit story");
    }

    if (empty($_SESSION['user_id'])) {
        header('Location: account.php');
        exit;
    }

    $username = $_SESSION['user_id'];
    $story_id = $_POST['story_id'];
    $edited_story = $_POST['edit_story'];

    $stmt = $mysqli->prepare('UPDATE user_stories SET story_content = ? WHERE story_id = ?');
    if (!$stmt) {
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('si', $edited_story, $story_id);
    $stmt->execute();
    $stmt->close();

    header("Location: account.php");

?>
    
</body>
</html>