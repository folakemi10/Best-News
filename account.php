<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>My Account </h1>
    <h2>Posts</h2>
    <?php
    session_start();
    require 'connectdatabase.php';
    $username = $_SESSION['user_id'];
    //display all stories in user_stories database in reverse chronological order
    //Use prepare statement to get story attributes
    $stmt = $mysqli->prepare('SELECT username, story_id, story_title, story_content, story_link, story_time, story_upvote, story_downvote FROM user_stories WHERE username=?');
    if (!$stmt) {
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('s', $username);
    $stmt->execute();

    //Bind the parameter
    $stmt->bind_result($username, $story_id, $story_title, $story_content, $story_link, $story_time, $story_upvote, $story_downvote);
    //loop

    while ($stmt->fetch()) {
        printf("<div class=homepage_story> " . htmlentities($story_title) . "<br>");
        printf(htmlentities($username));
        printf(htmlentities($story_time) . "<br>");
        printf(htmlentities($story_content) . "<br>");
        printf(htmlentities($story_link) . "<br>");
        printf(
            "
            <form action=\"editstory.php\" method = \"POST\">
                <input type=hidden name=\"story_id\" id=\"story_id\" value=\"" . $story_id . "\"/>
                <input type=submit name=\"edit\" id=\"edit\" value=\"Edit\"/>
            </form>

            <form action=\"deletestory.php\" method = \"POST\">
                <input type=hidden name=\"story_id\" id=\"story_id\" value=\"" . $story_id . "\"/>
                <input type=submit name=\"delete\" id=\"delete\" value=\"Delete\"/>
            </form>
            </div>"
        );
    }

    $stmt->close();
    ?>
    <h2>Comments</h2>
    <?php 

    ?>
</body>
</html>