<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Comment</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <?php
    require 'connectdatabase.php';
    session_start();
    //get story_id
    $username = $_SESSION['user_id'];
    $comment_id = $_POST['comment_id'];

    if (!hash_equals($_SESSION['token'], $_POST['token'])) {
        die("Request forgery detected for edit story");
    }

    if (empty($_SESSION['user_id'])) {
        header('Location: account.php');
        exit;
    }

    //get story information
    $stmt = $mysqli->prepare('SELECT comment_content FROM user_comments WHERE comment_id = ?');
    if (!$stmt) {
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('i', $comment_id);
    $stmt->execute();

    $stmt->bind_result($comment_content);
    $stmt->fetch();
    $stmt->close();

    echo "<h1> Edit Comment </h1>";
    echo "<form action=\"updatecomment.php\" method = \"POST\">
            <input class=create_story type=hidden name=\"token\" value=" . $_SESSION['token'] . ">
            <input class=create_story type=hidden name=\"comment_id\" id=\"comment_id\" value=\"" . $comment_id . "\"/>
            <textarea class=create_story name=\"edit_comment\" id = \"edit_comment\" rows=\"5\" cols=\"50\"> " . $comment_content . "</textarea>
            <input type=submit value = \"Update Comment\" />
        </form>";
    ?>

    <form action="account.php">
        <input type="submit" value="Back to My Account" />
    </form>


</body>

</html>