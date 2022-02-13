<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <?php
    //taken from PHP article on wiki
    session_start();

    //destroy session
    session_destroy();

    //go to login 
    header("Location: login.php");
    ?>
</body>

</html>