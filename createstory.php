<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Story</title>
</head>

<body>
    <?php
    require 'connectdatabase.php';
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_SESSION['user_id'];
        $title = $mysqli->real_escape_string($_POST["story_title"]);
        $content = $mysqli->real_escape_string($_POST["story_content"]);
        $link = $mysqli->real_escape_string($_POST["story_link"]);

        if(!hash_equals($_SESSION['token'], $_POST['token'])){
            die("Request forgery detected");
        }

        if ($username == null) {
            header('Location: homepage.php');
            exit;
        }
        echo $username;
        echo $title;
        echo $content;
        echo $link;
    
        $stmt = $mysqli->prepare("INSERT INTO user_stories (username, story_title, story_content, story_link) VALUES (?, ?, ?, ?)");
        if (!$stmt) {
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }

        $stmt->bind_param('ssss', $username, $title, $content, $link);
        $stmt->execute();
        $stmt->close();

        echo "Your story has been created. You will be returned to homepage.";
        //header("Refresh:5; url=homepage.php");
    }
    ?>

    <h1> Create Your Story </h1>
    <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
        <label> Story Title: <input type="text" id="story_title" name="story_title"> </label>
        <label> Story Body: <input type="text" id="story_content" name="story_content"> </label>
        <label> Story Link: <input type="text" id="story_link" name="story_link"> </label>

        <input type="submit" value="Create Story" />
        <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />

    </form>



</body>

</html>