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
    require 'connectdatabase.php';
    //display all stories in user_stories database in reverse chronological order 

    //Use prepare statement to get story attributes
    $get_story_data = $mysqli->prepare('SELECT id, username, story_id, story_title, story_content, story_link, story_time, story_upvote, story_downvote FROM user_stories');
    $get_story_data->execute();

    //Bind the parameter
    $get_story_data->bind_result($user_id, $username, $story_title, $story_content, $story_link, $story_time, $story_upvote, $story_downvote);

    //loop

    /*
    while ($story_data->fetch()) {
        printf(
            htmlspecialchars($username),
            htmlspecialchars($story_title),
            htmlspecialchars($story_content),
            htmlspecialchars($story_time),
            htmlspecialchars($story_link),
        );
    }
    $stmt->close();
    */






    //allow user to type in any title, body text, or link ***Should we take user to a seperate page for this?***
    //submit/post story

    //user can go to their account page to see all their stories and edit it

    //query from data base all stories 
    ?>

    <!-- go to account page button -->
    <div>
        <form action="account.php">
            <input type="submit" value="My Account" />
        </form>
    </div>

    <!-- logout button -->
    <div>
        <form action="login.php">
            <input type="submit" value="Logout" />
        </form>
    </div>

    <!-- created story button -->
    <div>
        <form action="createstory.php">
            <input type="submit" value="Create Story" />
        </form>
    </div>
</body>

</html>