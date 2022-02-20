<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upvote</title>
</head>

<body>
    <?php
    session_start();
    require("connectdatabase.php");


    if (!hash_equals($_SESSION['token'], $_POST['token'])) {
        die("Request forgery detected for edit story");
    }

    if (empty($_SESSION['user_id'])) {
        header('Location: homepage.php');
        exit;
    }

    $post_story_id = $_POST['story_id'];
    $already_voted = $_POST['already_voted'];

    //get curent number of upvotes
    $stmt = $mysqli->prepare("SELECT story_upvote, story_id FROM user_stories WHERE story_id=?");
    if (!$stmt) {
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('i', $post_story_id);
    $stmt->execute();
    $stmt->bind_result($upvotes, $story_id);
    $stmt->fetch();
    $stmt->close();

    //increase number of upvotes by one
    $upvotes += 1;


    //update new number of upvotes in database
    $stmt2 = $mysqli->prepare("UPDATE user_stories SET story_upvote = ? WHERE story_id = ?");
    if (!$stmt2) {
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt2->bind_param('ii', $upvotes, $story_id);
    $stmt2->execute();
    $stmt2->close();

    header("Location: homepage.php");
    ?>
</body>

</html>