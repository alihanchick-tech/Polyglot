<?php

    ob_start();
    session_start();
    
    $errors = array();
    $today = getdate();
    
    if(strlen($today['mon']) == 1)
    {
        $today_mon = '0' . $today['mon'];
    } else
    {
        $today_mon = $today['mon'];
    }
    
    if(strlen($today['mday']) == 1)
    {
        $today_mday = '0' . $today['mday'];
    } else
    {
        $today_mday = $today['mday'];
    }
    
    if(strlen(($today['hours'] + 5) % 24) == 1)
    {
        $today_hours = '0' . ($today['hours'] + 5) % 24;
    } else
    {
        $today_hours = $today['hours'] + 5;
    }
    
    if(strlen($today['minutes']) == 1)
    {
        $today_minutes = '0' . $today['minutes'];
    } else
    {
        $today_minutes = $today['minutes'];
    }
    
    if(strlen($today['seconds']) == 1)
    {
        $today_seconds = '0' . $today['seconds'];
    } else
    {
        $today_seconds = $today['seconds'];
    }
    
    if($_SERVER['PHP_SELF'] != '/book_reader/includes/jquery/login.php')
    {
        require_once('layout/header.php');
        require_once('data_class.php');
        require_once('functions.php');
    }

?>