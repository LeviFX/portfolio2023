<?php 

session_start();
include_once 'includes/components/navbar-cms.php';
include_once 'includes/components/notifications.php';

if (isset($_SESSION['session_username']) && !empty($_SESSION['session_level'])) {

    if (isset($_POST['project'])) {

        $project_name = htmlentities($_POST['input-Project_name']);
        $project_description = htmlentities($_POST['input-Project_description']);
        $project_link = htmlentities($_POST['input-Project_link']);
        $project_image = $_FILES['input-Project_image'];
        $project_visibility = htmlentities($_POST['input-Project_visibility']);
        $project_order = htmlentities($_POST['input-Project_order']);
        $project_size = htmlentities($_POST['input-Project_size']);

        if (is_numeric($project_order)) {

            if (isset($project_image)) {
                move_uploaded_file($project_image['tmp_name'], __DIR__ . "/includes/public/img/" . $project_image['name']);
            }

            require_once('includes/components/config.php');
            $query = 'INSERT INTO projects (project_name, project_description, project_link, project_image, visibility, project_order, size, created_by) VALUES (:project_name, :project_description, :project_link, :project_image, :visibility, :project_order, :size, :created_by)';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':project_name', $project_name);
            $stmt->bindParam(':project_description', $project_description);
            $stmt->bindParam(':project_link', $project_link);
            $stmt->bindParam(':project_image', $project_image['name']);
            $stmt->bindParam(':visibility', $project_visibility);
            $stmt->bindParam(':project_order', $project_order);
            $stmt->bindParam(':size', $project_size);
            $stmt->bindParam(':created_by', $_SESSION['session_user_id']);
            $stmt->execute();
            $stmt->closeCursor();

            $_SESSION['succes'] = array("Project succesfully added");

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
        <title>CMS | Projects</title>
        <link rel="icon" href="includes/img/favicon.png">
        <link rel="stylesheet" href="includes/css/cms.css">
        <script src="includes/js/main.js"></script>
    </head>
    <body>
        <div id="cms-content" class="cms-form">
            <fieldset class="view">
                <legend>Projects</legend>
            <?php
            
                require_once('includes/components/config.php');

                $query = 'SELECT * FROM projects ORDER BY project_order';
                $stmt = $pdo->prepare($query);
                $stmt->execute();
                $result = $stmt->fetchAll();
                $stmt->closeCursor();

                if ($stmt->rowCount() > 0) {
                    foreach($result as $row) {
                        ?>
                            <div class="card">
                                <h4><?=$row['project_name']?></h4>
                                <span><?=$row['project_description']?></span>
                                <span><?=$row['project_order']?></span>
                                <img src="includes/public/img/<?=$row['project_image']?>">
                                <a href="edit-projects.php?id=<?=$row['id']?>">Edit</a>
                            </div>
                        <?php
                    }
                } else {
                    echo "0 projects found";
                }

            ?>
            </fieldset>
            <fieldset class="add">
                <legend>Add</legend>
                <form action="" method="POST" enctype="multipart/form-data">
                    <label for="input-Project_name">Project title</label>
                    <input type="text" id="project_name" name="input-Project_name">
                    <label for="input-Project_description">Description</label>
                    <textarea id="project_description" name="input-Project_description"></textarea>
                    <label for="input-Project_link">Link</label>
                    <input type="text" id="project_link" name="input-Project_link">
                    <label for="input-Project_image">Image</label>
                    <input type="file" id="project_image" name="input-Project_image" accept="image/*">
                    <label for="input-Project_visibility">Visibility</label>
                    <select id="project_visibility" name="input-Project_visibility">
                        <option value="0">Visible</option>
                        <option value="1">Hidden</option>
                    </select>
                    <label for="input-Project_order">Order</label>
                    <input type="number" id="project_order" name="input-Project_order">
                    <label for="input-Project_size">Size</label>
                    <select id="project_size" name="input-Project_size">
                        <option value="0">Normal</option>
                        <option value="1">Wide</option>
                        <option value="2">Long</option>
                        <option value="3">Big</option>
                    </select>
                    <input type="submit" name="project">
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