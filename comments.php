<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comments</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php 
    session_start();
    require 'connectdatabase.php';
    $username = $_SESSION['user_id'];
    $story_id = $_POST['story_id'];
    $comment = $_POST['comment'];
    $up = 0;
    $down = 0;


    if(!hash_equals($_SESSION['token'], $_POST['token'])){
        die("Request forgery detected for comments");
    }

    if (empty($_SESSION['user_id'])) {
        header('Location: homepage.php');
        exit;
    }

    $stmt = $mysqli->prepare("INSERT INTO user_comments (username, comment_story, comment_content, comment_upvote, comment_downvote) values (?, ?, ?, ?, ?)");
        if (!$stmt) {
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }

        $stmt->bind_param('sssii', $username, $story_id, $comment, $up, $down);
        $stmt->execute();
        $stmt->close();

        header("Location: homepage.php");
    ?>
</body>
</html>