<?php
    
    require_once('../init.php');
    require_once('../data_class.php');
    
?>

<?php
    
    if(isset($_POST))
    {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $phone = $_POST['phone'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        $add_data = [
            'first_name' => $first_name,
            'last_name' => $last_name,
            'phone' => $phone,
            'username' => $username,
            'password' => $password
        ];

        if($data_class->add_data('users', $add_data))
        {
            echo 1;
        }
    }
    
?>