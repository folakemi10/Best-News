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
    $$username = $_SESSION['user_id'];
    //display all stories in user_stories database in reverse chronological order
    //Use prepare statement to get story attributes
    $stmt = $mysqli->prepare('SELECT username, story_id, story_title, story_content, story_link, story_time, story_upvote, story_downvote FROM user_stories');
    if (!$stmt) {
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->execute();

    //Bind the parameter
    $stmt->bind_result($username, $story_id, $story_title, $story_content, $story_link, $story_time, $story_upvote, $story_downvote);
    //loop

    while ($stmt->fetch()) {
        printf("<div class=homepage_story> " . htmlentities($story_title) . "<br>");
        printf(htmlentities($username));
        printf(htmlentities($story_time) . "<br>");
        printf(htmlentities($story_content) . "<br>");
        printf(htmlentities($story_link) . "</div>");
    }

    $stmt->close();
    ?>


    <!-- Buttons on homepage if logged in -->
    <!-- go to account page button -->
    <?php

    if (empty($_SESSION['user_id'])) {
        echo  "username should be blank here: " . $_SESSION['user_id'];
        //user not logged in
        echo "<div>
    <form action=\"login.php\">
        <input type=\"submit\" value=\"Login\" />
    </form>
    </div>";
    
    } else {
        //user is logged in
        echo  $_SESSION['user_id'];
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