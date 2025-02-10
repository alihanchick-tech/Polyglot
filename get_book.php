<?php require_once('../data_class.php'); ?>

<?php
    
    if(isset($_POST['search_key']))
    {
        if($_POST['search_key'] == 'sbn')
        {
            $book_info = $data_class->search_data('books', 'book_name', $_POST['search_val']);
        }
    } else
    {
        $book_info = $data_class->get_data('books');
    }
    
    if(!empty($book_info))
    {
        foreach($book_info as $key => $val)
        {
            echo '<tr>';
            echo '<td style="width: 35%;">' . $val['book_name'];
            
            if(!empty($val['book_cover']))
            {
                echo '<span style="margin-left: 10px; color: crimson; font-size: 1.5em;"><i class="fas fa-image"></i></span>';
            }
            
            echo '</td>';
            echo '<td style="width: 35%;">' . $data_class->get_data('writers', 'writer_id', $val['writer_id'])[0]['writer_name'] . '</td>';
            echo '<td style="width: 24%;">' . $data_class->get_data('genres', 'genre_id', $val['genre_id'])[0]['genre_name'] . '</td>';
            echo '<td style="width: 6%;"><a href="books.php?upd_book=' . $val['book_id']
                    . '"><i class="fas fa-pen-square"></i></a><a href="books.php?del_book='
                    . $val['book_id'] . '"><i class="fas fa-window-close"></i></a></td>';
            echo '</tr>';
        }
    } else
    {
        echo '<tr>';
        echo '<td colspan="2" style="color: crimson; font-weight: bold;">Netije tapylmady</td>';
        echo '</tr>';
    }
    
?>