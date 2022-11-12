<?php 

session_start();
include_once 'includes/components/navbar-cms.php';
include_once 'includes/components/notifications.php';

if (isset($_SESSION['session_username']) && !empty($_SESSION['session_level'])) {

    if (isset($_POST['editproject'])) {

        $project_name = htmlentities($_POST['input-Project_name']);
        $project_description = htmlentities($_POST['input-Project_description']);
        $project_link = htmlentities($_POST['input-Project_link']);
        $project_image = $_FILES['input-Project_image'];
        $project_imageEMPTY = htmlentities($_POST['input-Project_imageEMPTY']);
        $project_visibility = htmlentities($_POST['input-Project_visibility']);
        $project_order = htmlentities($_POST['input-Project_order']);
        $project_size = htmlentities($_POST['input-Project_size']);
        $project_hiddenID = htmlentities($_POST['input-Project_hiddenID']);

        if (is_numeric($project_order)) {

            if (isset($project_image)) {
                if ($project_image['name'] == "") {
                    $project_imageFINAL = $project_imageEMPTY;
                } else {
                    move_uploaded_file($project_image['tmp_name'], __DIR__ . "/includes/public/img/" . $project_image['name']);
                    $project_imageFINAL = $project_image['name'];
                }
            }

            require_once('includes/components/config.php');
            $query = 'UPDATE projects SET project_name = :project_name, project_description = :project_description, project_link = :project_link, project_image = :project_image, visibility = :visibility, project_order = :project_order, size = :size, created_by = :created_by WHERE id = :id';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':id', $project_hiddenID);
            $stmt->bindParam(':project_name', $project_name);
            $stmt->bindParam(':project_description', $project_description);
            $stmt->bindParam(':project_link', $project_link);
            $stmt->bindParam(':project_image', $project_imageFINAL);
            $stmt->bindParam(':visibility', $project_visibility);
            $stmt->bindParam(':project_order', $project_order);
            $stmt->bindParam(':size', $project_size);
            $stmt->bindParam(':created_by', $_SESSION['session_user_id']);
            $stmt->execute();
            $stmt->closeCursor();

            $_SESSION['succes'] = array("Project succesfully updated");
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
        <title>Edit project</title>
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

                    $query = 'SELECT * FROM projects WHERE id=:id';
                    $stmt = $pdo->prepare($query);
                    $stmt->bindParam(':id', $id);
                    $stmt->execute();
                    $result = $stmt->fetch();
                    $stmt->closeCursor();

                    if ($stmt->rowCount() > 0) {
                            ?>
                            <fieldset class="edit">
                                <legend>Edit</legend>
                                <form action="" method="POST" enctype="multipart/form-data">
                                    <label for="input-Project_name">Project title</label>
                                    <input type="text" id="project_name" name="input-Project_name" value="<?=$result['project_name']?>">
                                    <label for="input-Project_description">Description</label>
                                    <textarea id="project_description" name="input-Project_description"><?=$result['project_description']?></textarea>
                                    <label for="input-Project_link">Link</label>
                                    <input type="text" id="project_link" name="input-Project_link" value="<?=$result['project_link']?>">
                                    <label for="input-Project_image">Image <?=$result['project_image']?></label>
                                    <img src="includes/public/img/<?=$result['project_image']?>">
                                    <input type="file" id="project_image" name="input-Project_image" accept="image/*">
                                    <input type="hidden" id="project_imageEMPTY" name="input-Project_imageEMPTY" value="<?=$result['project_image']?>">
                                    <label for="input-Project_visibility">Visibility <?=$result['visibility']?></label>
                                    <select id="project_visibility" name="input-Project_visibility">
                                        <option value="0">Visible</option>
                                        <option value="1">Hidden</option>
                                    </select>
                                    <label for="input-Project_order">Order <?=$result['project_order']?></label>
                                    <input type="number" id="project_order" name="input-Project_order" value="<?=$result['project_order']?>">
                                    <label for="input-Project_size">Size <?=$result['size']?></label>
                                    <select id="project_size" name="input-Project_size">
                                        <option value="0">Normal</option>
                                        <option value="1">Wide</option>
                                        <option value="2">Long</option>
                                        <option value="3">Big</option>
                                    </select>
                                    <span>Created at: <?=$result['created_at']?></span>
                                    <span>Created by: <?=$result['created_by']?></span>
                                    <input type="hidden" id="project_hiddenID" name="input-Project_hiddenID" value="<?=$result['id']?>">
                                    <input type="submit" name="editproject">
                                </form>
                                <a href="delete-projects.php?id=<?=$result['id']?>&image=<?=$result['project_image']?>">Delete?</a>
                            </fieldset>
                            <?php
                    } else {
                        echo "No project found";
                    }
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