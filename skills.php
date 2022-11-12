<?php 

session_start();
include_once 'includes/components/navbar-cms.php';
include_once 'includes/components/notifications.php';

if (isset($_SESSION['session_username']) && !empty($_SESSION['session_level'])) {

    if (isset($_POST['skills'])) {

        $skill_group = htmlentities($_POST['input-Skill_group']);
        $skill_type = htmlentities($_POST['input-Skill_type']);
        $skill_percentage = htmlentities($_POST['input-Skill_percentage']);
        $skill_order = htmlentities($_POST['input-Skill_order']);

        if (is_numeric($skill_percentage)) {

            require_once('includes/components/config.php');
            $query = 'INSERT INTO skills (skill_group, skill, skill_percentage, skill_order) VALUES (:skill_group, :skill, :skill_percentage, :skill_order)';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':skill_group', $skill_group);
            $stmt->bindParam(':skill', $skill_type);
            $stmt->bindParam(':skill_percentage', $skill_percentage);
            $stmt->bindParam(':skill_order', $skill_order);
            $stmt->execute();
            $stmt->closeCursor();

            $_SESSION['succes'] = array("Skill succesfully added");

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
        <title>CMS | Skills</title>
        <link rel="icon" href="includes/img/favicon.png">
        <link rel="stylesheet" href="includes/css/cms.css">
        <script src="includes/js/main.js"></script>
    </head>
    <body>
        <div id="cms-content" class="cms-form">
            <fieldset class="view">
                <legend>Skills</legend>
            <?php
            
                require_once('includes/components/config.php');

                $query = 'SELECT * FROM skills ORDER BY skill_group, skill_order';
                $stmt = $pdo->prepare($query);
                $stmt->execute();
                $result = $stmt->fetchAll();
                $stmt->closeCursor();

                if ($stmt->rowCount() > 0) {
                    foreach($result as $row) {
                        ?>
                            <div class="card">
                                <h4><?=$row['skill_group']?></h4>
                                <span><?=$row['skill']?></span>
                                <span><?=$row['skill_percentage']?></span>
                                <span><?=$row['skill_order']?></span>
                                <a href="edit-skills.php?id=<?=$row['id']?>">Edit</a>
                            </div>
                        <?php
                    }
                } else {
                    echo "0 skills found.. :(";
                }

            ?>
            </fieldset>
            <fieldset class="add">
                <legend>Add</legend>
                <form action="" method="POST">
                    <label for="input-Skill_group">Skill group</label>
                    <input type="text" id="skill_group" name="input-Skill_group">
                    <label for="input-Skill_type">Skill</label>
                    <input type="text" id="skill_type" name="input-Skill_type">
                    <label for="input-Skill_percentage">Percentage</label>
                    <input type="range" min="0" max="100" value="0" id="skill_percentage" name="input-Skill_percentage" oninput="this.nextElementSibling.value = this.value"><output>0</output>
                    <label for="input-Skill_order">Order</label>
                    <input type="number" id="skill_order" name="input-Skill_order">
                    <input type="submit" name="skills">
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