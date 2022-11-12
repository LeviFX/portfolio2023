<?php 

session_start();
include_once 'includes/components/navbar-cms.php';
include_once 'includes/components/notifications.php';

if (isset($_SESSION['session_username']) && !empty($_SESSION['session_level'])) {

    if (isset($_POST['blogs'])) {

        $blog_name = htmlentities($_POST['input-Blog_name']);
        $blog_slug = htmlentities($_POST['input-Blog_slug']);
        $blog_content = htmlentities($_POST['input-Blog_content']);
        $blog_image = $_FILES['input-Blog_image'];

        if (!empty($blog_name)) {

            if (isset($blog_image)) {
                move_uploaded_file($blog_image['tmp_name'], __DIR__ . "/includes/public/img/thumb/" . $blog_image['name']);
            }

            require_once('includes/components/config.php');
            $query = 'INSERT INTO blogs (blog_name, blog_content, blog_slug, blog_image, created_by) VALUES (:blog_name, :blog_content, :blog_slug, :blog_image, :created_by)';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':blog_name', $blog_name);
            $stmt->bindParam(':blog_content', $blog_content);
            $stmt->bindParam(':blog_slug', $blog_slug);
            $stmt->bindParam(':blog_image', $blog_image['name']);
            $stmt->bindParam(':created_by', $_SESSION['session_user_id']);
            $stmt->execute();
            $stmt->closeCursor();

            $_SESSION['succes'] = array("Blog succesfully added");

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
        <title>CMS | Blogs</title>
        <link rel="icon" href="includes/img/favicon.png">
        <link rel="stylesheet" href="includes/css/cms.css">
        <script src="includes/js/main.js"></script>
    </head>
    <body>
        <div id="cms-content" class="cms-form">
            <fieldset class="view">
                <legend>Blogs</legend>
            <?php
            
                require_once('includes/components/config.php');

                $query = 'SELECT * FROM blogs';
                $stmt = $pdo->prepare($query);
                $stmt->execute();
                $result = $stmt->fetchAll();
                $stmt->closeCursor();

                if ($stmt->rowCount() > 0) {
                    foreach($result as $row) {
                        ?>
                            <div class="card">
                                <h4><?=$row['blog_name']?></h4>
                                <span><?=$row['blog_slug']?></span>
                                <img src="includes/public/img/thumb/<?=$row['blog_image']?>">
                                <a href="edit-blogs.php?id=<?=$row['id']?>">Edit</a>
                            </div>
                        <?php
                    }
                } else {
                    echo "0 blogs found";
                }

            ?>
            </fieldset>
            <fieldset class="add">
                <legend>Add</legend>
                <form action="" method="POST" enctype="multipart/form-data">
                    <label for="input-Blog_name">Blog title</label>
                    <textarea id="blog_name" name="input-Blog_name"></textarea>
                    <label for="input-Blog_slug">slug</label>
                    <input type="text" id="blog_slug" name="input-Blog_slug">
                    <label for="input-Blog_content">content</label>
                    <textarea id="blog_content" name="input-Blog_content"></textarea>
                    <label for="input-Blog_image">Thumbnail</label>
                    <input type="file" id="blog_image" name="input-Blog_image" accept="image/*">
                    <input type="submit" name="blogs">
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