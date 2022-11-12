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
        <title>CMS</title>
        <link rel="icon" href="includes/img/favicon.png">
        <link rel="stylesheet" href="includes/css/cms.css">
        <script src="includes/js/main.js"></script>
    </head>
    <body>
        <div id="cms-content">
            <fieldset class="cms projects">
                <legend>Projects</legend>
                <a href="projects.php">Edit</a>
            </fieldset>
            <fieldset class="cms blog">
                <legend>Blogs</legend>
                <a href="blogs.php">Edit</a>
            </fieldset>
            <fieldset class="cms skills">
                <legend>Skills</legend>
                <a href="skills.php">Edit</a>
            </fieldset>
            <fieldset class="cms funfact">
                <legend>FunFacts</legend>
                <a href="funfacts.php">Edit</a>
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