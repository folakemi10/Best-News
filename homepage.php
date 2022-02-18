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
    <div class=header>
        <h1 class=logo> Best News </h1>

        <!-- Buttons on homepage if logged in -->
        <!-- go to account page button -->
        <?php
        session_start();
        require 'connectdatabase.php';
        $username = $_SESSION['user_id'];


        if (empty($_SESSION['user_id'])) {
            //user not logged in

            echo "<div classname=headerButton>
        <form action=\"login.php\">
        <div loginButton>
        <input type=\"submit\" value=\"Login\" />
    </form>
            </div>
    </div>";
        } else {
            //user is logged in
            //takes user to their account page
            echo "<div classname=headerButton>
        <form action=\"account.php\">
        <div loginButton>
            <input type=\"submit\" value=\"My Account\" />
        </form>
        </div>
    </div>";

            //logout button
            echo "<div classname=headerButton>
        <form action=\"logout.php\">
            <input type=\"submit\" value=\"Logout\" />
        </form>
    </div>";

            //create a story
            echo "<div classname=headerButton>
        <form action=\"createstory.php\">
            <input type=\"submit\" value=\"Create Story\" />
        </form>
    </div>";
        }

        ?>
    </div>

    <?php

    //display all stories in user_stories database in reverse chronological order
    //Use prepare statement to get story attributes
    $stmt = $mysqli->prepare('SELECT user_stories.username, story_id, story_title, story_content, story_link, story_time, story_upvote, story_downvote, 
    user_comments.username, user_comments.comment_time, user_comments.comment_content FROM user_stories LEFT JOIN user_comments ON (user_stories.story_id = user_comments.comment_story) ORDER BY story_id DESC');
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
            printf("<h1 class=comment_headings>" . "Written by " . htmlentities($story_username));
            printf(" at " . htmlentities($story_time) . "<br>" . "</h1>");
            printf(htmlentities($story_content) . "<br>");
            printf(htmlentities($story_link) . "</div>");

            if (!empty($_SESSION['user_id'])) {
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
        }

        printf("<div class=homepage_comments> " . "<h1 class=comment_headings> " . htmlentities($comment_username) . " at ");
        printf(htmlentities($comment_time) . "<br>" . "</h1>");
        printf(htmlentities($comment_content) . "</div>");

        $past_story_id = $story_id;
    }
    $stmt->close();
    ?>

</body>

</html>