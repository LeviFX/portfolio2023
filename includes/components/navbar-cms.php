<?php
?>
<header id="header">
    <nav>
        <ul id="nav-link">
            <li><p>Welcome <?=$_SESSION['session_username']?></p></li>
            <li><a href="cms.php">CMS</a></li>
            <li><a href="projects.php">Projects</a></li>
            <li><a href="blogs.php">Blogs</a></li>
            <li><a href="skills.php">Skills</a></li>
            <li><a href="funfacts.php">FunFacts</a></li>
            <li><a href="logout.php">Logout</a></li>
            <div id="hamburger">
                <div class="line1"></div>
                <div class="line2"></div>
                <div class="line3"></div>
            </div>
        </ul>
    </nav>
</header>