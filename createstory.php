<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Story</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <?php
    require 'connectdatabase.php';
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_SESSION['user_id'];
        $title = $_POST["story_title"];
        $content = $_POST["story_content"];
        $link = $_POST["story_link"];
        $up = 0;
        $down = 0;

        if(!hash_equals($_SESSION['token'], $_POST['token'])){
            die("Request forgery detected");
        }

        if (empty($_SESSION['user_id'])) {
            header('Location: homepage.php');
            exit;
        }
        
        $stmt = $mysqli->prepare("INSERT INTO user_stories (username, story_title, story_content, story_link, story_upvote, story_downvote) values (?, ?, ?, ?, ?, ?)");
        if (!$stmt) {
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }

        $stmt->bind_param('ssssii', $username, $title, $content, $link, $up, $down);
        $stmt->execute();
        $stmt->close();

        header("Location: homepage.php");
    }
    ?>

    <h1> Create Your Story </h1>
    <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
        <label> Story Title: <input type="text" id="story_title" name="story_title"> </label>
        <label> Story Body: <input type="text" id="story_content" name="story_content"> </label>
        <label> Story Link: <input type="text" id="story_link" name="story_link"> </label>

        <input type="submit" value="Publish My Story" />
        <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
        <input formaction = "homepage.php" type="submit" value="Back to Home" />
    </form>
        



</body>

</html>