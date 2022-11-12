<?php 

session_start();
include_once 'includes/components/navbar-cms.php';
include_once 'includes/components/notifications.php';

if (isset($_SESSION['session_username']) && !empty($_SESSION['session_level'])) {

    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Delete skill</title>
        <link rel="stylesheet" href="includes/css/cms.css">
        <script src="includes/js/main.js"></script>
    </head>
    <body>
        <div id="cms-content" class="cms-form">
            <?php
            
                $id = htmlentities($_GET['id']);
                if (is_numeric($id)) {

                    require_once('includes/components/config.php');

                    $query = 'DELETE FROM skills WHERE id=:id';
                    $stmt = $pdo->prepare($query);
                    $stmt->bindParam(':id', $id);
                    $stmt->execute();
                    $stmt->closeCursor();

                    $_SESSION['succes'] = array("Skill succesfully removed");
                    header("Location: skills.php");
                    die();

                } else {
                    $_SESSION['error'] = array("Illegal ID");
                    header("Location: skills.php");
                    die();
                }
                
            ?>
        </div>
    </body>
    </html>
    <?php
    
} else {
    $_SESSION['error'] = array("No access");
    header("Location: login.php");
    die();
}
?>