<?php 

session_start();
include_once 'includes/components/notifications.php';

if (isset($_POST['login'])) {

    $username = htmlentities($_POST['input-Username']);
    $password = htmlentities($_POST['input-Password']);

    if (!empty($username && $password)) {

        require_once('includes/components/config.php');
        $query = 'SELECT * FROM users WHERE `user_name` = :username';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $result = $stmt->fetch();
        $stmt->closeCursor();

        if ($stmt->rowCount() == 1) {

            $passwordCheck = password_verify($password, $result['user_password']);

            if ($passwordCheck) {

                $_SESSION['session_user_id'] = $result['id'];
                $_SESSION['session_username'] = $result['user_name'];
                $_SESSION['session_level'] = $result['user_level'];

                header("Location: cms.php");

            } else {
                $_SESSION['error'] = array("Incorrect password");
                header("Location: ".$_SERVER['HTTP_REFERER']);
            }
    
        } else {
            $_SESSION['error'] = array("No account found");
            header("Location: ".$_SERVER['HTTP_REFERER']);
        }

    } else {
        $_SESSION['error'] = array("Invalid fields");
        header("Location: ".$_SERVER['HTTP_REFERER']);
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" href="includes/img/favicon.png">
    <link rel="stylesheet" href="includes/css/cms.css">
    <script src="includes/js/main.js"></script>
</head>
<body>
    <div id="cms-content" class="login-form">
        <form action="" method="POST">
            <label for="input-Username">Username</label>
            <input type="text" id="username" name="input-Username">
            <label for="input-Password">Password</label>
            <input type="password" id="password" name="input-Password">
            <input type="submit" name="login">
        </form>
    </div>
</body>
</html>