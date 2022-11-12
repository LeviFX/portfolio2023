<div id="notification-box">
<?php

    $types = array("succes", "error", "warning", "info");

    foreach($types as $type) {
        if (isset($_SESSION[$type]) && !empty($_SESSION[$type]) && is_array($_SESSION[$type])) {
            foreach($_SESSION[$type] as $message) {
                echo "<div class='notification $type'><svg class='close-notification' xmlns='http://www.w3.org/2000/svg' width='1em' height='1em' preserveAspectRatio='xMidYMid meet' viewBox='0 0 16 8'><path fill='currentColor' d='M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8L4.646 5.354a.5.5 0 0 1 0-.708z'/></svg><span><strong>$type</strong></span> $message </div>";
            }
            unset($_SESSION[$type]);
        }
    }
?>
</div>
