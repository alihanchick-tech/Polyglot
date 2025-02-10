<?php
    
    require_once('includes/init.php');
    require_once('includes/layout/aside.php');
    protect_page();
    
?>

<?php
    
    if(isset($_POST['change_password']))
    {
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $new_password2 = $_POST['new_password2'];
        
        if(empty($current_password))
        {
            $errors[] = 'Aktiw paroly ýaz';
        }
        
        if(empty($new_password))
        {
            $errors[] = 'Täze paroly ýaz';
        }
        
        if(empty($new_password2))
        {
            $errors[] = 'Täze paroly ýene bir gezek ýaz';
        }
        
        if($current_password != $_SESSION['user']['password'])
        {
            $errors[] = 'Ýazylan aktiw parol dogry däl';
        }
        
        if($new_password != $new_password2)
        {
            $errors[] = 'Täze parollar deň gelenok';
        }
        
        if(empty($errors))
        {
            $data_class->update_data('users', array('password' => $new_password), 'user_id', 1);
            $_SESSION['user']['password'] = $new_password;
            
            header('Location: change_password.php?success');
        }
    }
    
?>

<div class="content-wrapper">
    
    <?php require_once('includes/layout/panel_head.php'); ?>
    
    <?php
        
        if(isset($_GET['success']))
        {
            echo '<h2 style="color: green;">Parol üstünlik bilen üýtgedildi</h2>';
        } else {
        
    ?>
    
    <form method="post" class="panel" style="width: 40%;">
        <ul>
            <li>
                <input type="password" name="current_password" placeholder="Aktiw parol">
            </li>
            <li>
                <input type="password" name="new_password" placeholder="Täze parol">
            </li>
            <li>
                <input type="password" name="new_password2" placeholder="Täze parol (ýene)">
            </li>
            <li>
                <input type="submit" name="change_password" value="Üýtget" class="btn btn-danger">
            </li>
            <li><?php if(isset($_POST['change_password']) && !empty($errors)) { output_errors($errors); } ?></li>
        </ul>
    </form>
    
    <?php } ?>
    
    <?php require_once('includes/layout/panel_foot.php'); ?>
    
</div>

<?php require_once('includes/layout/footer.php'); ?>