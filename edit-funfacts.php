<?php 

session_start();
include_once 'includes/components/navbar-cms.php';
include_once 'includes/components/notifications.php';

if (isset($_SESSION['session_username']) && !empty($_SESSION['session_level'])) {

    if (isset($_POST['editfunfact'])) {

        $funfact = htmlentities($_POST['input-Funfact']);
        $funfact_hiddenID = htmlentities($_POST['input-Funfact_hiddenID']);

        if (is_numeric($funfact_hiddenID)) {

            require_once('includes/components/config.php');
            $query = 'UPDATE funfacts SET fact = :fact, created_by = :created_by WHERE id = :id';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':id', $funfact_hiddenID);
            $stmt->bindParam(':fact', $funfact);
            $stmt->bindParam(':created_by', $_SESSION['session_user_id']);
            $stmt->execute();
            $stmt->closeCursor();

            $_SESSION['succes'] = array("Funfact succesfully updated");
            header("Location: ".$_SERVER['HTTP_REFERER']);

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
        <title>Edit funfact</title>
        <link rel="icon" href="includes/img/favicon.png">
        <link rel="stylesheet" href="includes/css/cms.css">
        <script src="includes/js/main.js"></script>
    </head>
    <body>
        <div id="cms-content" class="cms-form">
            <?php
            
                $id = htmlentities($_GET['id']);
                if (is_numeric($id)) {

                    require_once('includes/components/config.php');

                    $query = 'SELECT * FROM funfacts WHERE id=:id';
                    $stmt = $pdo->prepare($query);
                    $stmt->bindParam(':id', $id);
                    $stmt->execute();
                    $result = $stmt->fetch();
                    $stmt->closeCursor();

                    if ($stmt->rowCount() > 0) {
                            ?>
                            <fieldset class="edit">
                                <legend>Edit</legend>
                                <form action="" method="POST">
                                    <label for="input-Funfact">Fact</label>
                                    <textarea id="funfact" name="input-Funfact"><?=$result['fact']?></textarea>
                                    <input type="hidden" id="funfact_hiddenID" name="input-Funfact_hiddenID" value="<?=$result['id']?>">
                                    <input type="submit" name="editfunfact">
                                </form>
                                <a href="delete-funfacts.php?id=<?=$result['id']?>">Delete?</a>
                            </fieldset>
                            <?php
                    } else {
                        echo "No funfact found";
                    }
                } else {
                    $_SESSION['error'] = array("Illegal ID");
                    header("Location: funfacts.php");
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