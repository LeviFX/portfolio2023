<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404</title>
    <meta name="theme-color" content="#282e36">
    <link rel="icon" href="includes/img/favicon.png">
    <link rel="stylesheet" href="includes/css/main.css">
</head>
<body>
    <?php
    session_start();
    include_once 'includes/components/notifications.php';
    ?>
    <div id="error404">
        <h1>Page not found</h1>
        <p>Go back to <a href="https://levi.cool/">levi.cool</a></p>
    </div>
</body>
</html>