<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Story</title>
</head>

<body>
    <?php
    require 'connectdatabase.php';
    session_start();
    //get story_id
    $username = $_SESSION['user_id'];
    $story_id = $_POST['story_id'];

    if(!hash_equals($_SESSION['token'], $_POST['token'])){
        die("Request forgery detected for edit story");
    }

    if (empty($_SESSION['user_id'])) {
        header('Location: account.php');
        exit;
    }

    //get story information
    $stmt = $mysqli->prepare('SELECT story_title, story_content, story_link FROM user_stories WHERE story_id = ?');
    if (!$stmt) {
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('i', $story_id);
    $stmt->execute();

    $stmt->bind_result($story_title, $story_content, $story_link);  
    $stmt->fetch();
    $stmt->close();

    echo "<h1> Edit Story </h1>";
    echo "<form action=\"updatestory.php\" method = \"POST\">
        <input type=hidden name=\"token\" value=" . $_SESSION['token'] . ">
            <input type=hidden name=\"story_id\" id=\"story_id\" value=\"" . $story_id . "\"/>
            <textarea name=\"edit_story\" id = \"edit_story\" rows=\"5\" cols=\"50\"> " . $story_content . "</textarea>
            <input type=submit value = \"Update Story\" />
        </form>";
?>

<form action="account.php">
    <input type="submit" value="Back to My Account" />
</form>


</body>

</html>