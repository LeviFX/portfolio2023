<?php

session_start();

if (isset($_POST['input-submit'])) {

    $mailto = "";
    $name = htmlentities($_POST['input-name']);
    $fromEmail = htmlentities($_POST['input-email']);
    $msg = htmlentities($_POST['input-message']);
    $subject = htmlentities($_POST['input-subject']);
    $headers = "From: $fromEmail";

    if (!empty($fromEmail) && !empty($msg)) {

        $message = "Name: " . $name . "\n" . "Email:" . $fromEmail . "\n\n" . "Message:" . "\n" . $msg;

        $result = mail($mailto, $subject, $message, $headers);

        if ($result) {
            $_SESSION['succes'] = array("Mail successfully send");
            header("Location: ../../");
        } else {
            $_SESSION['error'] = array("Something went wrong");
            header("Location: ../../");
        }

    } else {
        $_SESSION['error'] = array("Invalid fields");
        header("Location: ../../");
    }

} else {
    $_SESSION['error'] = array("Illegal submission");
    header("Location: ../../");
}
