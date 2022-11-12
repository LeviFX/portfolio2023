<?php 

session_start();
include_once 'includes/components/navbar-cms.php';
include_once 'includes/components/notifications.php';

if (isset($_SESSION['session_username']) && !empty($_SESSION['session_level'])) {

    if (isset($_POST['editskill'])) {

        $skill_group = htmlentities($_POST['input-Skill_group']);
        $skill_type = htmlentities($_POST['input-Skill_type']);
        $skill_percentage = htmlentities($_POST['input-Skill_percentage']);
        $skill_order = htmlentities($_POST['input-Skill_order']);
        $skill_hiddenID = htmlentities($_POST['input-Skill_hiddenID']);

        if (is_numeric($skill_percentage)) {

            require_once('includes/components/config.php');
            $query = 'UPDATE skills SET skill_group = :skill_group, skill = :skill, skill_percentage = :skill_percentage, skill_order = :skill_order WHERE id = :id';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':id', $skill_hiddenID);
            $stmt->bindParam(':skill_group', $skill_group);
            $stmt->bindParam(':skill', $skill_type);
            $stmt->bindParam(':skill_percentage', $skill_percentage);
            $stmt->bindParam(':skill_order', $skill_order);
            $stmt->execute();
            $stmt->closeCursor();

            $_SESSION['succes'] = array("Skill succesfully updated");
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
        <title>Edit skill</title>
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

                    $query = 'SELECT * FROM skills WHERE id=:id';
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
                                    <label for="input-Skill_group">Skill group</label>
                                    <input type="text" id="skill_group" name="input-Skill_group" value="<?=$result['skill_group']?>">
                                    <label for="input-Skill_type">Skill</label>
                                    <input type="text" id="skill_type" name="input-Skill_type" value="<?=$result['skill']?>">
                                    <label for="input-Skill_percentage">Percentage</label>
                                    <input type="range" min="0" max="100" value="<?=$result['skill_percentage']?>" id="skill_percentage" name="input-Skill_percentage" oninput="this.nextElementSibling.value = this.value"><output><?=$result['skill_percentage']?></output>
                                    <label for="input-Skill_order">Order</label>
                                    <input type="number" id="skill_order" name="input-Skill_order" value="<?=$result['skill_order']?>">
                                    <span>Created at: <?=$result['created_at']?></span>
                                    <input type="hidden" id="skill_hiddenID" name="input-Skill_hiddenID" value="<?=$result['id']?>">
                                    <input type="submit" name="editskill">
                                </form>
                                <a href="delete-skills.php?id=<?=$result['id']?>">Delete?</a>
                            </fieldset>
                            <?php
                    } else {
                        echo "No skills found.. :(";
                    }
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