<?php
    
    require_once('../init.php');
    require_once('../data_class.php');
    
?>

<?php
    
    if(isset($_POST))
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        if(!empty($data_class->get_data_2_key('users', 'username', $username, 'password', $password)))
        {
            $_SESSION['user']['username'] = $_POST['username'];
            $_SESSION['user']['password'] = $_POST['password'];
            echo 1;
        } else
        {
            echo 0;
        }
    }
    
?>