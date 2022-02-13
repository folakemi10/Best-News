<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connect Database</title>
</head>

<body>
    <?php
    // connect to database with module3admin user in MySQL
    //create user 'module3admin'@'localhost' identified by '123456';

    $mysqli = new mysqli('localhost', 'module3admin', '123456', 'module3users');

    if ($mysqli->connect_errno) {
        printf("Connection Failed: %s\n", $mysqli->connect_error);
        exit;
    }
    ?>
</body>

</html>