<?php
    
    require_once('includes/init.php');
    require_once('includes/layout/aside.php');
    protect_page();
    
?>

<?php
    
    if(isset($_POST['add_writer']))
    {
        $writer_name = $_POST['writer_name'];
        
        if(empty($writer_name))
        {
            $errors[] = 'Ýazyjy adyny ýazmaly';
        }
        
        if($data_class->data_exists('writers', 'writer_name', $writer_name))
        {
            $errors[] = 'Bu ýazyjy ady ulgamda bar';
        }
        
        if(empty($errors))
        {
            $data_class->add_data('writers', array('writer_name' => $writer_name));
            header('Location: writers.php');
        }
    }
    
?>

<?php
    
    if(isset($_GET['del_writer']))
    {
        $data_class->delete_data('writers', 'writer_id', $_GET['del_writer']);
        header('Location: writers.php');
    }
    
?>

<?php
    
    if(isset($_POST['update_writer']))
    {
        $writer_name = $_POST['writer_name'];
        
        if(empty($writer_name))
        {
            $errors[] = 'Ýazyjy adyny ýazmaly';
        }
        
        if(empty($errors))
        {
            $data_class->update_data('writers', array('writer_name' => $writer_name), 'writer_id', $_GET['upd_writer']);
            header('Location: writers.php');
        }
    }
    
?>

<div class="content-wrapper">
    
    <?php require_once('includes/layout/panel_head.php'); ?>
    
    <?php
        
        if(isset($_GET['add_writer']))
        {
            echo '<p><a href="writers.php"><i class="fas fa-minus-square"></i> Goýbolsun et</a></p>';
        } else
        {
            echo '<p><a href="writers.php?add_writer"><i class="fas fa-plus-square"></i> Ýazyjy goş</a></p>';
        }
        
    ?>
    
    <?php if(isset($_GET['add_writer'])) { ?>
    
    <form method="post" class="panel" style="width: 40%;">
        <ul>
            <li>
                <input type="text" name="writer_name" placeholder="Ýazyjy ady"
                       value="<?php if(isset($_POST['writer_name'])) { echo $_POST['writer_name']; } ?>">
            </li>
            <li>
                <input type="submit" name="add_writer" value="Goş" class="btn btn-danger">
            </li>
            <li><?php if(isset($_POST['add_writer']) && !empty($errors)) { output_errors($errors); } ?></li>
        </ul>
    </form>
    
    <?php
        
        } else if(isset($_GET['upd_writer']))
        {
            $upd_writer_info = $data_class->get_data('writers', 'writer_id', $_GET['upd_writer'])[0];
        
    ?>
    
    <form method="post" class="panel" style="width: 40%;">
        <ul>
            <li>
                <input type="text" name="writer_name" placeholder="Ýazyjy ady"
                       value="<?php if(isset($_POST['writer_name'])) { echo $_POST['writer_name']; }
                                    else { echo $upd_writer_info['writer_name']; }?>">
            </li>
            <li>
                <input type="submit" name="update_writer" value="Üýtget" class="btn btn-danger">
            </li>
            <li><?php if(isset($_POST['upd_writer']) && !empty($errors)) { output_errors($errors); } ?></li>
        </ul>
    </form>
    
    <?php } ?>
    
    <?php
        
        $writer_info = $data_class->get_data('writers');
        
        if(!empty($writer_info))
        {
            echo '<hr>';
            echo '<table class="panel">';
            echo '<tr><th>Ýazyjy</th><th></th></tr>';
            
            foreach($writer_info as $key => $val)
            {
                echo '<tr>';
                echo '<td>' . $val['writer_name'] . '</td>';
                echo '<td><a href="writers.php?upd_writer=' . $val['writer_id']
                    . '"><i class="fas fa-pen-square"></i></a><a href="writers.php?del_writer='
                    . $val['writer_id'] . '"><i class="fas fa-window-close"></i></a></td>';
                echo '</tr>';
            }
            
            echo '</table>';
        }
        
    ?>
    
    <?php require_once('includes/layout/panel_foot.php'); ?>
    
</div>

<?php require_once('includes/layout/footer.php'); ?>