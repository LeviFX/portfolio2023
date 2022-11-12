<?php 

session_start();
include_once 'includes/components/navbar-cms.php';
include_once 'includes/components/notifications.php';

if (isset($_SESSION['session_username']) && !empty($_SESSION['session_level'])) {

    if (isset($_POST['editblog'])) {

        $blog_name = htmlentities($_POST['input-Blog_name']);
        $blog_slug = htmlentities($_POST['input-Blog_slug']);
        $blog_content = htmlentities($_POST['input-Blog_content']);
        $blog_image = $_FILES['input-Blog_image'];
        $blog_imageEMPTY = htmlentities($_POST['input-Blog_imageEMPTY']);
        $blog_hiddenID = htmlentities($_POST['input-Blog_hiddenID']);

        if (is_numeric($blog_hiddenID)) {

            if (isset($blog_image)) {
                if ($blog_image['name'] == "") {
                    $blog_imageFINAL = $blog_imageEMPTY;
                } else {
                    move_uploaded_file($blog_image['tmp_name'], __DIR__ . "/includes/public/img/thumb/" . $blog_image['name']);
                    $blog_imageFINAL = $blog_image['name'];
                }
            }

            require_once('includes/components/config.php');
            $query = 'UPDATE blogs SET blog_name = :blog_name, blog_content = :blog_content, blog_slug = :blog_slug, blog_image = :blog_image, created_by = :created_by WHERE id = :id';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':id', $blog_hiddenID);
            $stmt->bindParam(':blog_name', $blog_name);
            $stmt->bindParam(':blog_content', $blog_content);
            $stmt->bindParam(':blog_slug', $blog_slug);
            $stmt->bindParam(':blog_image', $blog_imageFINAL);
            $stmt->bindParam(':created_by', $_SESSION['session_user_id']);
            $stmt->execute();
            $stmt->closeCursor();

            $_SESSION['succes'] = array("Blog succesfully updated");
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
        <title>Edit blog</title>
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

                    $query = 'SELECT * FROM blogs WHERE id=:id';
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
                                    <label for="input-Blog_name">Blog title</label>
                                    <textarea id="blog_name" name="input-Blog_name"><?=$result['blog_name']?></textarea>
                                    <label for="input-Blog_slug">slug</label>
                                    <input type="text" id="blog_slug" name="input-Blog_slug" value="<?=$result['blog_slug']?>">
                                    <label for="input-Blog_content">content</label>
                                    <textarea id="blog_content" name="input-Blog_content"><?=$result['blog_content']?></textarea>
                                    <img src="includes/public/img/thumb/<?=$result['blog_image']?>">
                                    <input type="file" id="blog_image" name="input-Blog_image" accept="image/*">
                                    <input type="hidden" id="blog_imageEMPTY" name="input-Blog_imageEMPTY" value="<?=$result['blog_image']?>">
                                    <input type="hidden" id="blog_hiddenID" name="input-Blog_hiddenID" value="<?=$result['id']?>">
                                    <input type="submit" name="editblog">
                                </form>
                                <a href="delete-blogs.php?id=<?=$result['id']?>&image=<?=$result['blog_image']?>">Delete?</a>
                            </fieldset>
                            <?php
                    } else {
                        echo "No blog found";
                    }
                } else {
                    $_SESSION['error'] = array("Illegal ID");
                    header("Location: blogs.php");
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