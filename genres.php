<?php
    
    require_once('includes/init.php');
    require_once('includes/layout/aside.php');
    protect_page();
    
?>

<?php
    
    if(isset($_POST['add_genre']))
    {
        $genre_name = $_POST['genre_name'];
        
        if(empty($genre_name))
        {
            $errors[] = 'Bölüm adyny ýazmaly';
        }
        
        if($data_class->data_exists('genres', 'genre_name', $genre_name))
        {
            $errors[] = 'Bu bölüm ady ulgamda bar';
        }
        
        if(empty($errors))
        {
            $data_class->add_data('genres', array('genre_name' => $genre_name));
            header('Location: genres.php');
        }
    }
    
?>

<?php
    
    if(isset($_GET['del_genre']))
    {
        $data_class->delete_data('genres', 'genre_id', $_GET['del_genre']);
        header('Location: genres.php');
    }
    
?>

<?php
    
    if(isset($_POST['update_genre']))
    {
        $genre_name = $_POST['genre_name'];
        
        if(empty($genre_name))
        {
            $errors[] = 'Bölüm adyny ýazmaly';
        }
        
        if(empty($errors))
        {
            $data_class->update_data('genres', array('genre_name' => $genre_name), 'genre_id', $_GET['upd_genre']);
            header('Location: genres.php');
        }
    }
    
?>

<div class="content-wrapper">
    
    <?php require_once('includes/layout/panel_head.php'); ?>
    
    <?php
        
        if(isset($_GET['add_genre']))
        {
            echo '<p><a href="genres.php"><i class="fas fa-minus-square"></i> Goýbolsun et</a></p>';
        } else
        {
            echo '<p><a href="genres.php?add_genre"><i class="fas fa-plus-square"></i> Bölüm goş</a></p>';
        }
        
    ?>
    
    <?php if(isset($_GET['add_genre'])) { ?>
    
    <form method="post" class="panel" style="width: 40%;">
        <ul>
            <li>
                <input type="text" name="genre_name" placeholder="Bölüm ady"
                       value="<?php if(isset($_POST['genre_name'])) { echo $_POST['genre_name']; } ?>">
            </li>
            <li>
                <input type="submit" name="add_genre" value="Goş" class="btn btn-danger">
            </li>
            <li><?php if(isset($_POST['add_genre']) && !empty($errors)) { output_errors($errors); } ?></li>
        </ul>
    </form>
    
    <?php
        
        } else if(isset($_GET['upd_genre']))
        {
            $upd_genre_info = $data_class->get_data('genres', 'genre_id', $_GET['upd_genre'])[0];
        
    ?>
    
    <form method="post" class="panel" style="width: 40%;">
        <ul>
            <li>
                <input type="text" name="genre_name" placeholder="Bölüm ady"
                       value="<?php if(isset($_POST['genre_name'])) { echo $_POST['genre_name']; }
                                    else { echo $upd_genre_info['genre_name']; }?>">
            </li>
            <li>
                <input type="submit" name="update_genre" value="Üýtget" class="btn btn-danger">
            </li>
            <li><?php if(isset($_POST['upd_genre']) && !empty($errors)) { output_errors($errors); } ?></li>
        </ul>
    </form>
    
    <?php } ?>
    
    <?php
        
        $genre_info = $data_class->get_data('genres');
        
        if(!empty($genre_info))
        {
            echo '<hr>';
            echo '<table class="panel">';
            echo '<tr><th>Bölüm</th><th></th></tr>';
            
            foreach($genre_info as $key => $val)
            {
                echo '<tr>';
                echo '<td>' . $val['genre_name'] . '</td>';
                echo '<td><a href="genres.php?upd_genre=' . $val['genre_id']
                    . '"><i class="fas fa-pen-square"></i></a><a href="genres.php?del_genre='
                    . $val['genre_id'] . '"><i class="fas fa-window-close"></i></a></td>';
                echo '</tr>';
            }
            
            echo '</table>';
        }
        
    ?>
    
    <?php require_once('includes/layout/panel_foot.php'); ?>
    
</div>

<?php require_once('includes/layout/footer.php'); ?>