<?php 

session_start();
include_once 'includes/components/navbar-cms.php';
include_once 'includes/components/notifications.php';

if (isset($_SESSION['session_username']) && !empty($_SESSION['session_level'])) {

    if (isset($_POST['funfacts'])) {

        $funfact = htmlentities($_POST['input-Funfact']);

        if (!empty($funfact)) {

            require_once('includes/components/config.php');
            $query = 'INSERT INTO funfacts (fact, created_by) VALUES (:fact, :created_by)';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':fact', $funfact);
            $stmt->bindParam(':created_by', $_SESSION['session_user_id']);
            $stmt->execute();
            $stmt->closeCursor();

            $_SESSION['succes'] = array("Funfact succesfully added");

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
        <title>CMS | FunFacts</title>
        <link rel="icon" href="includes/img/favicon.png">
        <link rel="stylesheet" href="includes/css/cms.css">
        <script src="includes/js/main.js"></script>
    </head>
    <body>
        <div id="cms-content" class="cms-form">
            <fieldset class="view">
                <legend>FunFacts</legend>
            <?php
            
                require_once('includes/components/config.php');

                $query = 'SELECT * FROM funfacts';
                $stmt = $pdo->prepare($query);
                $stmt->execute();
                $result = $stmt->fetchAll();
                $stmt->closeCursor();

                if ($stmt->rowCount() > 0) {
                    foreach($result as $row) {
                        ?>
                            <div class="card">
                                <h4><?=$row['id']?></h4>
                                <span><?=$row['fact']?></span>
                                <a href="edit-funfacts.php?id=<?=$row['id']?>">Edit</a>
                            </div>
                        <?php
                    }
                } else {
                    echo "0 funfacts found";
                }

            ?>
            </fieldset>
            <fieldset class="add">
                <legend>Add</legend>
                <form action="" method="POST">
                    <label for="input-Skill_group">Fun fact</label>
                    <textarea id="funfact" name="input-Funfact"></textarea>
                    <input type="submit" name="funfacts">
                </form>
            </fieldset>
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