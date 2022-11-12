<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>levi.cool</title>
    <meta name="description" content="Levi's portfolio">
    <meta name="theme-color" content="#282e36">
    <link rel="icon" href="includes/img/favicon.png">
    <meta property="og:image" content="https://levi.cool/includes/img/banner.webp">
    <link rel="stylesheet" href="includes/css/main.css">
    <script src="includes/js/typed.min.js"></script>
    <script type="module" src="includes/js/main.js"></script>
</head>
<body>
    <?php
    session_start();
    require_once('includes/components/config.php');
    include_once 'includes/components/navbar.php';
    include_once 'includes/components/notifications.php';
    ?>
    <div id="main-content">
        <div class="land">
            <svg id="down-arrow" xmlns="http://www.w3.org/2000/svg" width="2vh" height="2vh" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path fill="currentColor" d="M11.178 19.569a.998.998 0 0 0 1.644 0l9-13A.999.999 0 0 0 21 5H3a1.002 1.002 0 0 0-.822 1.569l9 13z"/></svg>
            <div class="greeting">
                <span>Hi 👋</span>
                <span>I'm a 
                <div id="greeting-strings">
                    <span>Creative Developer</span>
                    <span>3D Artist</span>
                    <span>Motion Designer</span>
                </div>
                <span id="greeting-message"></span>
                </span>
            </div>
            <div class="bubble" id="bubble-work">Work</div>
            <div class="bubble" id="bubble-skills">Skills</div>
            <div class="bubble" id="bubble-blog">Blog</div>
            <div class="bubble" id="bubble-contact">Contact</div>
            <div id="three"></div>
        </div>
        <div class="content">
            <div class="work" id="work">
                <div class="grid">
                    <?php
                    
                    $query = 'SELECT * FROM projects WHERE visibility = 0 ORDER BY project_order';
                    $stmt = $pdo->prepare($query);
                    $stmt->execute();
                    $result = $stmt->fetchAll();
                    $stmt->closeCursor();

                    if ($stmt->rowCount() > 0) {
                        
                        foreach($result as $row) {

                            if ($row['size'] == 0) {
                                $size = "";
                            } else if ($row['size'] == 1) {
                                $size = "wide";
                            } else if ($row['size'] == 2) {
                                $size = "large";
                            } else if ($row['size'] == 3) {
                                $size = "big";
                            }

                            ?>
                                <a class="card <?=$size?>"<?php if (!empty($row['project_link'])) {?> href="<?=$row['project_link']?>" target="_blank" rel="noopener noreferrer"<?php }?>>
                                <?php
                                    if (!empty($row['project_image'])) {
                                        ?>
                                            <img src="includes/public/img/<?=$row['project_image']?>" alt="<?=$row['project_name']?>">
                                        <?php
                                    }
                                ?>
                                    <div>
                                        <h1><?=$row['project_name']?></h1>
                                        <span><?=$row['project_description']?></span>
                                    </div>
                                </a>
                            <?php
                        }
                    } else {
                        echo "0 projects found";
                    }
                    
                    ?>
                </div>
            </div>
            <div class="skills" id="skills">
                <div class="strengths">
                    <div class="hexagon-wrapper">
                        <div class="hexagon purple">
                        <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" preserveAspectRatio="xMidYMid meet" viewBox="0 0 20 20"><path fill="currentColor" d="M10 10L2.54 7.02L3 18H1l.48-11.41L0 6l10-4l10 4zm0-5c-.55 0-1 .22-1 .5s.45.5 1 .5s1-.22 1-.5s-.45-.5-1-.5zm0 6l5.57-2.23c.71.94 1.2 2.07 1.36 3.3c-.3-.04-.61-.07-.93-.07c-2.55 0-4.78 1.37-6 3.41A6.986 6.986 0 0 0 4 12c-.32 0-.63.03-.93.07c.16-1.23.65-2.36 1.36-3.3z"/></svg>
                            <h2>Fast Learner</h2>
                        </div>
                    </div>
                    <div class="hexagon-wrapper">
                        <div class="hexagon green">
                        <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" preserveAspectRatio="xMidYMid meet" viewBox="0 0 448 512"><path fill="currentColor" d="M413.8 447.1L256 448v31.99c0 17.71-14.2 32.01-31.9 32.01c-17.67 0-32.1-14.32-32.1-31.99v-31.99l-158.9-.01c-28.5 0-43.69-34.49-24.69-56.4l68.98-79.59H62.22c-25.41 0-39.15-29.8-22.67-49.13l60.41-70.85H89.21c-21.28 0-32.87-22.5-19.28-37.31l134.8-146.5c10.4-11.3 28.22-11.3 38.62-.003l134.9 146.5c13.62 14.81 2.001 37.31-19.28 37.31H348.2l60.35 70.86c16.46 19.34 2.716 49.12-22.68 49.12h-15.2l68.98 79.59C458.7 413.7 443.1 447.1 413.8 447.1z"/></svg>
                            <h2>Calm & Collective</h2>
                        </div>
                    </div>
                    <div class="hexagon-wrapper">
                        <div class="hexagon orange">
                        <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1200 1200"><path fill="currentColor" d="M454.771 10.997c-76.209-40.113-226.406 37.395-269.553 105.63c-19.222 30.534-17.862 52.538-17.862 65.022v667.874L730.602 1200l105.917-57.833V491.739L258.215 159.706c31.033-39.057 100.827-86.683 153.16-67.555l515.104 275.498l.001 724.58l106.184-57.936V309.728L454.771 10.997z"/></svg>
                            <h2>Research</h2>
                        </div>
                    </div>
                    <div class="hexagon-wrapper">
                        <div class="hexagon blue">
                        <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" preserveAspectRatio="xMidYMid meet" viewBox="0 0 48 48"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"><path d="m38 21l5 9l-5 1v6h-3l-6-1l-1 7H13l-2-10.381C7.92 29.703 6 25.576 6 21c0-8.837 7.163-16 16-16s16 7.163 16 16Z"/><path d="M17 19a5 5 0 1 1 5 5v3m0 6v1"/></g></svg>
                            <h2>Problem solver</h2>
                        </div>
                    </div>
                </div>
                <div class="bars">
                <?php

                    $skills = array("Dev", "3D", "Design", "Other");

                    foreach($skills as $sqlvalue) {
                        ?>
                        <fieldset id="<?=$sqlvalue?>-skills">
                            <legend><?=$sqlvalue?></legend>
                        <?php

                        $query = 'SELECT skill, skill_percentage FROM skills WHERE skill_group = :skill_group ORDER BY skill_order';
                        $stmt = $pdo->prepare($query);
                        $stmt->bindParam(':skill_group', $sqlvalue);
                        $stmt->execute();
                        $result = $stmt->fetchAll();
                        $stmt->closeCursor();

                        if ($stmt->rowCount() > 0) {
                            foreach($result as $row) {
                                ?>
                                <div class="progress-bar-wrap">
                                    <p><?=$row['skill']?></p>
                                    <div class="progress-bar">
                                        <span style="width: <?=$row['skill_percentage']?>%;"></span>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            echo "<p>No skill found</p>";
                        }
                        ?>
                        </fieldset>
                        <?php
                    }
                ?>
                </div>
            </div>
            <div class="blogs" id="blogs">
                <div class="blogs-wrap">
                    <h1 class="blog-link">Blogs</h1>
                    <div class="featured">
                        <?php
                        $query = 'SELECT blog_name, blog_slug, blog_image FROM blogs';
                        $stmt = $pdo->prepare($query);
                        $stmt->execute();
                        $result = $stmt->fetchAll();
                        $stmt->closeCursor();

                        if ($stmt->rowCount() > 0) {
                            foreach($result as $row) {
                                ?>
                                    <a class="blog" href="<?=$row['blog_slug']?>" target="_blank" rel="noopener noreferrer">
                                        <div class="blog-img">
                                            <?php
                                            if (!empty($row['blog_image'])) {
                                                ?>
                                                    <img src="includes/public/img/thumb/<?=$row['blog_image']?>" alt="<?=$row['blog_name']?>">
                                                <?php
                                            }
                                            ?>
                                            <h2 class="blog-title"><?=$row['blog_name']?></h2>
                                        </div>
                                    </a>
                                <?php
                            }
                        } else {
                            echo "<p>There are no blogs yet :( ...</p>";
                        }
                        ?>         
                    </div>
                </div>
            </div>
            <div class="contact" id="contact">
                <div class="contact-form">
                    <h1>Contact</h1>
                    <form action="includes/components/mail.php" method="POST">
                        <div class="form-right">
                            <textarea id="input-message" name="input-message" placeholder="Message"></textarea>
                        </div>
                        <div class="form-left">
                            <input type="text" id="input-name" name="input-name" placeholder="Name">
                            <input type="email" id="input-email" name="input-email" placeholder="Email">
                            <input type="text" id="input-subject" name="input-subject" placeholder="Subject">
                            <input type="submit" id="input-submit" name="input-submit" value="Send">
                        </div>
                        <ul>
                            <li>
                                <a href="https://www.instagram.com/levi_slavi/" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M7.465 1.066C8.638 1.012 9.012 1 12 1c2.988 0 3.362.013 4.534.066c1.172.053 1.972.24 2.672.511c.733.277 1.398.71 1.948 1.27c.56.549.992 1.213 1.268 1.947c.272.7.458 1.5.512 2.67C22.988 8.639 23 9.013 23 12c0 2.988-.013 3.362-.066 4.535c-.053 1.17-.24 1.97-.512 2.67a5.396 5.396 0 0 1-1.268 1.949c-.55.56-1.215.992-1.948 1.268c-.7.272-1.5.458-2.67.512c-1.174.054-1.548.066-4.536.066c-2.988 0-3.362-.013-4.535-.066c-1.17-.053-1.97-.24-2.67-.512a5.397 5.397 0 0 1-1.949-1.268a5.392 5.392 0 0 1-1.269-1.948c-.271-.7-.457-1.5-.511-2.67C1.012 15.361 1 14.987 1 12c0-2.988.013-3.362.066-4.534c.053-1.172.24-1.972.511-2.672a5.396 5.396 0 0 1 1.27-1.948a5.392 5.392 0 0 1 1.947-1.269c.7-.271 1.5-.457 2.67-.511Zm8.98 1.98c-1.16-.053-1.508-.064-4.445-.064c-2.937 0-3.285.011-4.445.064c-1.073.049-1.655.228-2.043.379c-.513.2-.88.437-1.265.822a3.412 3.412 0 0 0-.822 1.265c-.151.388-.33.97-.379 2.043c-.053 1.16-.064 1.508-.064 4.445c0 2.937.011 3.285.064 4.445c.049 1.073.228 1.655.379 2.043c.176.477.457.91.822 1.265c.355.365.788.646 1.265.822c.388.151.97.33 2.043.379c1.16.053 1.507.064 4.445.064c2.938 0 3.285-.011 4.445-.064c1.073-.049 1.655-.228 2.043-.379c.513-.2.88-.437 1.265-.822c.365-.355.646-.788.822-1.265c.151-.388.33-.97.379-2.043c.053-1.16.064-1.508.064-4.445c0-2.937-.011-3.285-.064-4.445c-.049-1.073-.228-1.655-.379-2.043c-.2-.513-.437-.88-.822-1.265a3.413 3.413 0 0 0-1.265-.822c-.388-.151-.97-.33-2.043-.379Zm-5.85 12.345a3.669 3.669 0 0 0 4-5.986a3.67 3.67 0 1 0-4 5.986ZM8.002 8.002a5.654 5.654 0 1 1 7.996 7.996a5.654 5.654 0 0 1-7.996-7.996Zm10.906-.814a1.337 1.337 0 1 0-1.89-1.89a1.337 1.337 0 0 0 1.89 1.89Z" clip-rule="evenodd"/></svg></a>
                            </li>
                            <li>
                                <a href="https://www.behance.net/leviv" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><g fill="none"><g clip-path="url(#svgIDa)"><path fill="currentColor" d="M22 7h-7V5h7v2Zm1.726 10c-.442 1.297-2.029 3-5.101 3c-3.074 0-5.564-1.729-5.564-5.675c0-3.91 2.325-5.92 5.466-5.92c3.082 0 4.964 1.782 5.375 4.426c.078.506.109 1.188.095 2.14H15.97c.13 3.211 3.483 3.312 4.588 2.029h3.168Zm-7.686-4h4.965c-.105-1.547-1.136-2.219-2.477-2.219c-1.466 0-2.277.768-2.488 2.219Zm-9.574 6.988H0V5.021h6.953c5.476.081 5.58 5.444 2.72 6.906c3.461 1.26 3.577 8.061-3.207 8.061ZM3 11h3.584c2.508 0 2.906-3-.312-3H3v3Zm3.391 3H3v3.016h3.341c3.055 0 2.868-3.016.05-3.016Z"/></g><defs><clipPath id="svgIDa"><path fill="#fff" d="M0 0h24v24H0z"/></clipPath></defs></g></svg></a>
                            </li>
                            <li>
                                <a href="https://github.com/LeviFX" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385c.6.105.825-.255.825-.57c0-.285-.015-1.23-.015-2.235c-3.015.555-3.795-.735-4.035-1.41c-.135-.345-.72-1.41-1.23-1.695c-.42-.225-1.02-.78-.015-.795c.945-.015 1.62.87 1.845 1.23c1.08 1.815 2.805 1.305 3.495.99c.105-.78.42-1.305.765-1.605c-2.67-.3-5.46-1.335-5.46-5.925c0-1.305.465-2.385 1.23-3.225c-.12-.3-.54-1.53.12-3.18c0 0 1.005-.315 3.3 1.23c.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23c.66 1.65.24 2.88.12 3.18c.765.84 1.23 1.905 1.23 3.225c0 4.605-2.805 5.625-5.475 5.925c.435.375.81 1.095.81 2.22c0 1.605-.015 2.895-.015 3.3c0 .315.225.69.825.57A12.02 12.02 0 0 0 24 12c0-6.63-5.37-12-12-12Z" clip-rule="evenodd"/></svg></a>
                            </li>
                            <li>
                                <a href="https://www.linkedin.com/in/levi-vogel-37770320b/" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M1 2.838A1.838 1.838 0 0 1 2.838 1H21.16A1.837 1.837 0 0 1 23 2.838V21.16A1.838 1.838 0 0 1 21.161 23H2.838A1.838 1.838 0 0 1 1 21.161V2.838Zm8.708 6.55h2.979v1.496c.43-.86 1.53-1.634 3.183-1.634c3.169 0 3.92 1.713 3.92 4.856v5.822h-3.207v-5.106c0-1.79-.43-2.8-1.522-2.8c-1.515 0-2.145 1.089-2.145 2.8v5.106H9.708V9.388Zm-5.5 10.403h3.208V9.25H4.208v10.54ZM7.875 5.812a2.063 2.063 0 1 1-4.125 0a2.063 2.063 0 0 1 4.125 0Z" clip-rule="evenodd"/></svg></a>
                            </li>
                        </ul>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php include_once 'includes/components/footer.php'; ?>
</body>
</html>