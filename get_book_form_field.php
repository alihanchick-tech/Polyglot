<?php require_once('../data_class.php'); ?>

<?php
    
    if(isset($_POST['tag_count']))
    {
        $i = $_POST['tag_count'] + 1;
    }
    
    if(isset($_POST['add_tag']) && ($_POST['add_tag'] == 'h1' || $_POST['add_tag'] == 'h2' || $_POST['add_tag'] == 'h3'))
    {
        echo '<li class="setir">';
        echo '<input type="text" name="tag_no-' . $i . '" placeholder="Header-' . $_POST['add_tag'][1] . ' ýaz">';
        echo '<input type="text" hidden="hidden" name="tag_name-' . $i . '" value="h' . $_POST['add_tag'][1] . '">';
        echo '</li>';
    } else if(isset($_POST['add_tag']) && $_POST['add_tag'] == 'p')
    {
        echo '<li class="setir">';
        echo '<textarea name="tag_no-' . $i . '" style="width: 97%; height: 300px; margin-left: 5px;"></textarea>';
        echo '<input type="text" hidden="hidden" name="tag_name-' . $i . '" value="p">';
        echo '</li>';
    } else if(isset($_POST['add_tag']) && $_POST['add_tag'] == 'img')
    {
        echo '<li class="setir">';
        echo '<input type="file" name="tag_no-' . $i . '">';
        echo '<input type="text" hidden="hidden" name="tag_name-' . $i . '" value="img">';
        echo '</li>';
    }
    
?>