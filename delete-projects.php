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
        <title>Delete project</title>
        <link rel="stylesheet" href="includes/css/cms.css">
        <script src="includes/js/main.js"></script>
    </head>
    <body>
        <div id="cms-content" class="cms-form">
            <?php
            
                $id = htmlentities($_GET['id']);
                if (is_numeric($id)) {

                    $imagename = htmlentities($_GET['image']);
                    $imagepath = "includes/public/img/$imagename";

                    require_once('includes/components/config.php');

                    $query = 'DELETE FROM projects WHERE id=:id';
                    $stmt = $pdo->prepare($query);
                    $stmt->bindParam(':id', $id);
                    $stmt->execute();
                    $stmt->closeCursor();
                    if (file_exists($imagepath)) {
                        unlink($imagepath);
                    }
                    $_SESSION['succes'] = array("Project succesfully removed");
                    header("Location: projects.php");
                    die();

                } else {
                    $_SESSION['error'] = array("Illegal ID");
                    header("Location: projects.php");
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