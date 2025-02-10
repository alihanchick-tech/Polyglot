<?php require_once('includes/init.php'); ?>

<?php
    
    session_destroy();
    header('Location: index.php');
    
?>

<?php require_once('includes/layout/footer.php'); ?>