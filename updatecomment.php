<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Comment</title>
</head>

<body>
    <?php
    require 'connectdatabase.php';
    session_start();

    if(!hash_equals($_SESSION['token'], $_POST['token'])){
        die("Request forgery detected for edit story");
    }

    if (empty($_SESSION['user_id'])) {
        header('Location: account.php');
        exit;
    }

    $username = $_SESSION['user_id'];
    $comment_id = $_POST['comment_id'];
    $edited_comment = $_POST['edit_comment'];

    $stmt = $mysqli->prepare('UPDATE user_comments SET comment_content = ? WHERE comment_id = ?');
    if (!$stmt) {
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('si', $edited_comment, $comment_id);
    $stmt->execute();
    $stmt->close();

    header("Location: account.php");
    ?>
</body>

</html>