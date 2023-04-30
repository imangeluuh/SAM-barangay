<?php
        // If a session is not already started, start a new session
        if(!session_id()){
            session_start(); 
        } 

        if(array_key_exists('en_button', $_POST)) {
            $_SESSION['lang'] = 'en';
        }
        else if(array_key_exists('fil_button', $_POST)) {
            $_SESSION['lang'] = 'fil';
        } 

        require_once "../language/" . $_SESSION['lang'] . ".php";

        header('Location: ../resident/res_homepage.php');
    ?>