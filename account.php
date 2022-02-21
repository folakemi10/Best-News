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
    <form action="homepage.php">
        <input type="submit" value="Back to Home" />
    </form>
    <?php
    session_start();
    require 'connectdatabase.php';
    $username = $_SESSION['user_id'];

    echo "<form action=\"deleteuser.php\" method = \"POST\">
        <input type=hidden name=\"token\" value=" . $_SESSION['token'] . ">
        <div class=deleteAccount>
        <input class=deleteAccount type=submit name=\"deleteuser\" id=\"deleteuser\" value=\"Delete My Account\"/>
        </div>
    </form>";

    echo "<h1>My Account </h1>";
    echo "<h3> Welcome, " . $_SESSION['user_id'] . "</h3>";
    echo "<h2>Posts</h2>";
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
    $stmt->bind_result($story_username, $story_id, $story_title, $story_content, $story_link, $story_time, $story_upvote, $story_downvote);
    //loop

    while ($stmt->fetch()) {
        printf("<div class=homepage_story> " . htmlentities($story_title) . "<br>");
        printf(htmlentities($story_username));
        printf(htmlentities($story_time) . "<br>");
        printf(htmlentities($story_content) . "<br>");
        printf(htmlentities($story_link) . "<br>");
        printf("<p> Points: " . htmlentities($story_upvote) . " </p>");
        printf(
            "<form action=\"editstory.php\" method = \"POST\">
                <input type=hidden name=\"token\" value=" . $_SESSION['token'] . ">
                <input type=hidden name=\"story_id\" id=\"story_id\" value=\"" . $story_id . "\"/>
                <input type=submit name=\"edit\" id=\"edit\" value=\"Edit\"/>
            </form>

            <form action=\"deletestory.php\" method = \"POST\">
                <input type=hidden name=\"token\" value=" . $_SESSION['token'] . ">
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
    $stmt2 = $mysqli->prepare('SELECT username, comment_id, comment_story, comment_time, comment_content, comment_upvote, comment_downvote FROM user_comments WHERE username=?');
    if (!$stmt2) {
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt2->bind_param('s', $username);
    $stmt2->execute();

    //Bind the parameter
    $stmt2->bind_result($comment_username, $comment_id, $comment_story, $comment_time, $comment_content, $comment_upvote, $comment_downvote);

    while ($stmt2->fetch()) {
        printf("<div class = homepage_comments> " . htmlentities($comment_username));
        printf(htmlentities($comment_time) . "<br>");
        printf(htmlentities($comment_content) . "<br>");
        printf(
            "<form action=\"editcomment.php\" method = \"POST\">
            <input type=hidden name=\"token\" value=" . $_SESSION['token'] . ">
            <input type=hidden name=\"comment_id\" id=\"comment_id\" value=\"" . $comment_id . "\"/>
            <input type=submit name=\"edit\" id=\"edit\" value=\"Edit\"/>
        </form>

        <form action=\"deletecomment.php\" method = \"POST\">
            <input type=hidden name=\"token\" value=" . $_SESSION['token'] . ">
            <input type=hidden name=\"comment_id\" id=\"comment_id\" value=\"" . $comment_id . "\"/>
            <input type=submit name=\"delete\" id=\"delete\" value=\"Delete\"/>
        </form>
        </div>"
        );
    }
    $stmt2->close();
    ?>
</body>

</html>