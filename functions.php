<?php require_once('database/config.php'); ?>

<?php

    function output_errors($errors)
    {
        echo '<ul class="error"><li>' . implode('</li><li>', $errors) . '</li></ul>';
    }
    
    function protect_page()
    {
        if(!isset($_SESSION['user']))
        {
            header('Location: index.php');
        }
    }

?>