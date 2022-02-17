<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <h1> Best News </h1>
    <?php
    session_start();
    require 'connectdatabase.php';
    $username = $_SESSION['user_id'];

    //display all stories in user_stories database in reverse chronological order
    //Use prepare statement to get story attributes
    $stmt = $mysqli->prepare('SELECT user_stories.username, story_id, story_title, story_content, story_link, story_time, story_upvote, story_downvote, 
    user_comments.username, user_comments.comment_time, user_comments.comment_content FROM user_stories LEFT JOIN user_comments ON (user_stories.story_id = user_comments.comment_story)');
    if (!$stmt) {
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }

    //Bind the parameter
    $stmt->bind_result($story_username, $story_id, $story_title, $story_content, $story_link, $story_time, $story_upvote, $story_downvote, $comment_username, $comment_time, $comment_content);
    $stmt->execute();

    while ($stmt->fetch()) {
        if ($story_id != $past_story_id) {
            printf("<div class=homepage_story> " . htmlentities($story_title) . "<br>");
            printf(htmlentities($story_username));
            printf(htmlentities($story_time) . "<br>");
            printf(htmlentities($story_content) . "<br>");
            printf(htmlentities($story_link) . "</div>");

            //print area for leaving comments
            printf(
                "<form action=\"comments.php\" method = \"POST\">
                    <input type=hidden name=\"story_id\" id=\"story_id\" value=\"" . $story_id . "\"/>
                    <input type=hidden name=\"token\" value=" . $_SESSION['token'] . ">
                    <label> Leave a Comment: <input type=text name=\"comment\" id=\"comment\" </label>
                    <input type=submit name=\"post_comment\" id=\"post_comment\" value=\"Post\"/>
                </form>"
            );
        }

        printf("<div class=homepage_comments> " . htmlentities($comment_username) . "<br>");
        printf(htmlentities($comment_time) . "<br>");
        printf(htmlentities($comment_content) . "</div>");

        $past_story_id = $story_id;
        
    }
    $stmt->close();
    ?>


    <!-- Buttons on homepage if logged in -->
    <!-- go to account page button -->
    <?php

    if (empty($_SESSION['user_id'])) {
        //user not logged in
        echo "<div>
        <form action=\"login.php\">
            <input type=\"submit\" value=\"Login\" />
        </form>
    </div>";
    } else {
        //user is logged in
        //takes user to their account page
        echo "<div>
        <form action=\"account.php\">
            <input type=\"submit\" value=\"My Account\" />
        </form>
    </div>";

        //logout button
        echo "<div>
        <form action=\"logout.php\">
            <input type=\"submit\" value=\"Logout\" />
        </form>
    </div>";

        //create a story
        echo "<div>
        <form action=\"createstory.php\">
            <input type=\"submit\" value=\"Create Story\" />
        </form>
    </div>";
    }
    ?>

</body>

</html>