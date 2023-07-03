<?php
        // If a session is not already started, start a new session
        if(!session_id()){
            session_start(); 
        } 

        if(array_key_exists('en_button', $_POST)) {
            $_SESSION['lang'] = 'en';
            if(isset($_POST['language']) && $_POST['language'] == "yes") {
                setcookie('preferredLanguage', 'en', time() + (86400 * 30), "/");
            }
        }
        else if(array_key_exists('fil_button', $_POST)) {
            $_SESSION['lang'] = 'fil';
            if(isset($_POST['language']) && $_POST['language'] == "yes") {
                setcookie('preferredLanguage', 'fil', time() + (86400 * 30), "/");
            }
        } 

        require_once "../language/" . $_SESSION['lang'] . ".php";

        header('Location: ../resident/res_homepage.php');
    ?>