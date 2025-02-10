<?php
    
    require_once('includes/init.php');
    require_once('includes/layout/aside.php');
    protect_page();
    
?>

<?php
    
    if(isset($_POST['add_book']))
    {
        $tag_count = $_POST['tag_count'];
        $writer_id = $_POST['writer_id'];
        $genre_id = $_POST['genre_id'];
        $book_name = $_POST['book_name'];
        $book_content = '';
        
        if(empty($writer_id))
        {
            $errors[] = 'Kitabyň awtoryny saýlamaly';
        }
        
        if(empty($genre_id))
        {
            $errors[] = 'Kitabyň bölümini saýlamaly';
        }
        
        if(empty($book_name))
        {
            $errors[] = 'Kitabyň adyny ýazmaly';
        }
        
        if(!empty($_FILES['book_cover']['name']))
        {
            $allowed = array('jpg', 'jpeg', 'png', 'JPG', 'JPEG', 'PNG');
            $file_name = basename($_FILES['book_cover']['name']);
            $file_size = $_FILES['book_cover']['size'];
            $max_file_size = "3145728"; // 3 mb
            
            $tmp = explode('.', $file_name);
            $file_extn = end($tmp);
            
            $file_temp = $_FILES['book_cover']['tmp_name'];
            
            if(!in_array($file_extn, $allowed))
            {
                $errors[] = "Bu faýl formaty rugsat berilmeýär. Rugsat berilýän faýl formatlary: jpg, jpeg, png";
            }
            
            if($file_size > $max_file_size)
            {
                $errors[] = "Faýlyň ölçegi 3 mb-den uly bolmaly däl";
            }
        }
        
        if(isset($_POST['tag_count']) && !empty($_POST['tag_count']))
        {
            $img_count = 0;
            
            for($i = 1; $i <= $tag_count; $i++)
            {
                if(isset($_POST['tag_no-' . $i]))
                {
                    $tag_no = $_POST['tag_no-' . $i];
                } else if(isset($_FILES['tag_no-' . $i]['name']))
                {
                    $tag_no = $_FILES['tag_no-' . $i];
                }
                
                $tag_name = $_POST['tag_name-' . $i];
                
                if(!empty($tag_no) && ($tag_name == 'h1' || $tag_name == 'h2' || $tag_name == 'h3'))
                {
                    $book_content .= '<' . $tag_name . '>'. $tag_no . '</' . $tag_name . '>';
                    
                    /*
                    if($i != $tag_count)
                    {
                        $book_content .= ' --- ';
                    }
                    */
                    
                    $book_content .= ' --- ';
                }
                
                if(!empty($tag_no) && ($tag_name == 'p'))
                {
                    $xp_par = explode("\n", $tag_no);
                    
                    for($j = 0; $j < count($xp_par); $j++)
                    {
                        if(md5($xp_par[$j]) == 'dcb9be2f604e5df91deb9659bed4748d')
                        {
                            unset($xp_par[$j]);
                        }
                    }
                    
                    if(!empty($xp_par))
                    {
                        $imp_par = '<p>' . implode('</p><p>', $xp_par) . '</p>';
                        $book_content .= $imp_par;
                        
                        if($i != $tag_count)
                        {
                            $book_content .= ' --- ';
                        }
                    }
                }
                
                if($tag_name == 'img')
                {
                    $img_errors = array();
                    
                    if(!empty($tag_no['name']))
                    {
                        $allowed = array('jpg', 'jpeg', 'png', 'JPG', 'JPEG', 'PNG');
                        $bi_file_name = basename($tag_no['name']);
                        $bi_file_size = $tag_no['size'];
                        $bi_max_file_size = "2097152"; // 2 mb
                        
                        $bi_tmp = explode('.', $bi_file_name);
                        $bi_file_extn = end($bi_tmp);
                        
                        $bi_file_temp = $tag_no['tmp_name'];
                        
                        if(!in_array($bi_file_extn, $allowed))
                        {
                            $img_errors[] = "Bu faýl formaty rugsat berilmeýär. Rugsat berilýän faýl formatlary: jpg, jpeg, png";
                        }
                        
                        if($file_size > $max_file_size)
                        {
                            $img_errors[] = "Suratyň ölçegi 2 mb-den uly bolmaly däl";
                        }
                    }
                    
                    if(empty($img_errors))
                    {
                        if(!empty($bi_file_temp))
                        {
                            $bi_file_path = 'img/book_img/' . substr(md5($bi_file_name), 0, 10) . '.' . $bi_file_extn;
                            move_uploaded_file($bi_file_temp, $bi_file_path);
                        } else
                        {
                            $bi_file_path = 0;
                        }
                    }
                    
                    if(!empty($bi_file_path))
                    {
                        $book_content .= '<img src="' . $bi_file_path . '">';
                        $book_content .= ' --- ';
                    }
                }
            }
        }
        
        if(empty($errors))
        {
            if(!empty($file_temp))
            {
                $file_path = 'img/book_cover/' . substr(md5($file_name), 0, 10) . '.' . $file_extn;
                move_uploaded_file($file_temp, $file_path);
            } else
            {
                $file_path = 0;
            }
            
            $add_data = array(
                'writer_id' => $writer_id,
                'genre_id' => $genre_id,
                'book_name' => $book_name,
                'book_cover' => $file_path,
                'book_content' => $book_content
            );
            
            $data_class->add_data('books', $add_data);
            header('Location: books.php');
        }
    }
    
?>

<?php
    
    if(isset($_GET['del_book']))
    {
        $data_class->delete_data('books', 'book_id', $_GET['del_book']);
        header('Location: books.php');
    }
    
?>

<?php
    
    if(isset($_POST['update_book']))
    {
        $upd_book_info = $data_class->get_data('books', 'book_id', $_GET['upd_book'])[0];
        $tag_count = $_POST['tag_count'];
        $writer_id = $_POST['writer_id'];
        $genre_id = $_POST['genre_id'];
        $book_name = $_POST['book_name'];
        $book_content = '';
        
        if(empty($writer_id))
        {
            $errors[] = 'Kitabyň awtoryny saýlamaly';
        }
        
        if(empty($genre_id))
        {
            $errors[] = 'Kitabyň bölümini saýlamaly';
        }
        
        if(empty($book_name))
        {
            $errors[] = 'Kitabyň adyny ýazmaly';
        }
        
        if(!empty($_FILES['book_cover']['name']))
        {
            $allowed = array('jpg', 'jpeg', 'png', 'JPG', 'JPEG', 'PNG');
            $file_name = basename($_FILES['book_cover']['name']);
            $file_size = $_FILES['book_cover']['size'];
            $max_file_size = "3145728"; // 3 mb
            
            $tmp = explode('.', $file_name);
            $file_extn = end($tmp);
            
            $file_temp = $_FILES['book_cover']['tmp_name'];
            
            if(!in_array($file_extn, $allowed))
            {
                $errors[] = "Bu faýl formaty rugsat berilmeýär. Rugsat berilýän faýl formatlary: jpg, jpeg, png";
            }
            
            if($file_size > $max_file_size)
            {
                $errors[] = "Faýlyň ölçegi 3 mb-den uly bolmaly däl";
            }
        }
        
        if(isset($_POST['tag_count']) && !empty($_POST['tag_count']))
        {
            for($i = 1; $i <= $tag_count; $i++)
            {
                if(isset($_POST['tag_no-' . $i]))
                {
                    $tag_no = $_POST['tag_no-' . $i];
                } else if(isset($_FILES['tag_no-' . $i]['name']))
                {
                    $tag_no = $_FILES['tag_no-' . $i];
                }
                
                $tag_name = $_POST['tag_name-' . $i];
                
                if(!empty($tag_no) && ($tag_name == 'h1' || $tag_name == 'h2' || $tag_name == 'h3'))
                {
                    $book_content .= '<' . $tag_name . '>'. $tag_no . '</' . $tag_name . '>';
                    
                    /*
                    if($i != $tag_count)
                    {
                        $book_content .= ' --- ';
                    }
                    */
                    
                    $book_content .= ' --- ';
                }
                
                if(!empty($tag_no) && $tag_name == 'p')
                {
                    $xp_par = explode("\n", $tag_no);
                    
                    for($j = 0; $j < count($xp_par); $j++)
                    {
                        if(md5($xp_par[$j]) == 'dcb9be2f604e5df91deb9659bed4748d')
                        {
                            unset($xp_par[$j]);
                        }
                    }
                    
                    if(!empty($xp_par))
                    {
                        $imp_par = '<p>' . implode('</p><p>', $xp_par) . '</p>';
                        $book_content .= $imp_par;
                        
                        if($i != $tag_count)
                        {
                            $book_content .= ' --- ';
                        }   
                    }
                }
                
                if($tag_name == 'img')
                {
                    $img_errors = array();
                    
                    if(!empty($tag_no['name']))
                    {
                        $allowed = array('jpg', 'jpeg', 'png', 'JPG', 'JPEG', 'PNG');
                        $bi_file_name = basename($tag_no['name']);
                        $bi_file_size = $tag_no['size'];
                        $bi_max_file_size = "2097152"; // 2 mb
                        
                        $bi_tmp = explode('.', $bi_file_name);
                        $bi_file_extn = end($bi_tmp);
                        
                        $bi_file_temp = $tag_no['tmp_name'];
                        
                        if(!in_array($bi_file_extn, $allowed))
                        {
                            $img_errors[] = "Bu faýl formaty rugsat berilmeýär. Rugsat berilýän faýl formatlary: jpg, jpeg, png";
                        }
                        
                        if($file_size > $max_file_size)
                        {
                            $img_errors[] = "Suratyň ölçegi 2 mb-den uly bolmaly däl";
                        }
                    }
                    
                    if(empty($img_errors))
                    {
                        if(!empty($bi_file_temp))
                        {
                            if('img/book_img/' . $_POST['tag_val-' . $i] != 'img/book_img/' . substr(md5($bi_file_name), 0, 10)
                                                                            . '.' . $bi_file_extn)
                            {
                                $bi_file_path = 'img/book_img/' . substr(md5($bi_file_name), 0, 10) . '.' . $bi_file_extn;
                                move_uploaded_file($bi_file_temp, $bi_file_path);
                            } else
                            {
                                $bi_file_path = 'img/book_img/' . $_POST['tag_val-' . $i];
                            }
                        } else
                        {
                            $bi_file_path = 'img/book_img/' . $_POST['tag_val-' . $i];
                        }
                    }
                    
                    if(!empty($bi_file_path))
                    {
                        $book_content .= '<img src="' . $bi_file_path . '">';
                        $book_content .= ' --- ';
                    }
                }
            }
        }
        
        if(empty($errors))
        {
            if(!empty($file_temp))
            {
                if($upd_book_info['book_cover'] != $file_path)
                {
                    $file_path = 'img/book_cover/' . substr(md5($file_name), 0, 10) . '.' . $file_extn;
                    move_uploaded_file($file_temp, $file_path);
                } else
                {
                    $file_path = $upd_book_info['book_cover'];
                }
            } else
            {
                $file_path = $upd_book_info['book_cover'];
            }
            
            $update_data = array(
                'writer_id' => $writer_id,
                'genre_id' => $genre_id,
                'book_name' => $book_name,
                'book_cover' => $file_path,
                'book_content' => $book_content
            );
            
            $data_class->update_data('books', $update_data, 'book_id', $_GET['upd_book']);
            header('Location: books.php');
        }
    }
    
?>

<div class="content-wrapper">
    
    <?php require_once('includes/layout/panel_head.php'); ?>
    
    <?php
        
        if(isset($_GET['add_book']))
        {
            echo '<p><a href="books.php"><i class="fas fa-minus-square"></i> Goýbolsun et</a></p>';
        } else
        {
            echo '<p><a href="books.php?add_book"><i class="fas fa-plus-square"></i> Kitap goş</a></p>';
        }
        
    ?>
    
    <?php if(isset($_GET['add_book'])) { ?>
    
    <form method="post" enctype="multipart/form-data" class="book_form" style="width: 100%;">
        <ul>
            <li>
                <input type="file" name="book_cover">
            </li>
            <li>
                <input type="text" name="book_name" placeholder="Kitabyň ady"
                       value="<?php if(isset($_POST['book_name'])) { echo $_POST['book_name']; } ?>">
                <select name="writer_id">
                    <option value="">Ýazyjyny saýla</option>
                    
                    <?php
                        
                        foreach($data_class->get_data('writers') as $key => $val)
                        {
                            echo '<option value="' . $val['writer_id'] . '"';
                            
                            if(isset($_POST['writer_id']) && $_POST['writer_id'] == $val['writer_id'])
                            {
                                echo ' selected="selected"';
                            }
                            
                            echo '>' . $val['writer_name'] . '</option>';
                        }
                        
                    ?>
                    
                </select>
                <select name="genre_id">
                    <option value="">Bölüm saýla</option>
                    
                    <?php
                        
                        foreach($data_class->get_data('genres') as $key => $val)
                        {
                            echo '<option value="' . $val['genre_id'] . '"';
                            
                            if(isset($_POST['genre_id']) && $_POST['genre_id'] == $val['genre_id'])
                            {
                                echo ' selected="selected"';
                            }
                            
                            echo '>' . $val['genre_name'] . '</option>';
                        }
                        
                    ?>
                    
                </select>
            </li>
            <li class="setir"></li>
            
            <?php
                
                if(isset($_POST['tag_count']) && !empty($_POST['tag_count']))
                {
                    for($i = 1; $i <= $_POST['tag_count']; $i++)
                    {
                        if(isset($_POST['tag_no-' . $i]))
                        {
                            $tag_no = $_POST['tag_no-' . $i];
                        } else if(isset($_FILES['tag_no-' . $i]['name']))
                        {
                            $tag_no = $_FILES['tag_no-' . $i];
                        }
                        
                        $tag_name = $_POST['tag_name-' . $i];
                        
                        if($tag_name == 'h1' || $tag_name == 'h2' || $tag_name == 'h3')
                        {
                            echo '<li class="setir">';
                            echo '<input type="text" name="tag_no-' . $i . '" placeholder="' . $tag_name . ' ýaz"';
                            
                            if(isset($tag_no))
                            {
                                echo ' value="' . $tag_no . '"';
                            }
                            
                            echo '>';
                            echo '<input type="text" hidden="hidden" name="tag_name-' . $i . '" value="' . $tag_name . '">';
                            echo '</li>';
                        }
                        
                        if($tag_name == 'p')
                        {
                            echo '<li class="setir">';
                            echo '<textarea name="tag_no-' . $i . '" style="width: 97%; height: 300px; margin-left: 5px;">';
                            
                            if(isset($tag_no))
                            {
                                echo $tag_no;
                            }
                            
                            echo '</textarea>';
                            echo '<input type="text" hidden="hidden" name="tag_name-' . $i . '" value="p">';
                            echo '</li>';
                        }
                        
                        if($tag_name == 'img')
                        {
                            echo '<li class="setir">';
                            echo '<input type="file" name="tag_no-' . $i . '">';
                            echo '<span>' . $tag_no['name'] . '</span>';
                            echo '<input type="text" hidden="hidden" name="tag_name-' . $i . '" value="img">';
                            echo '</li>';
                        }
                    }
                }
                
            ?>
            
            <li>
                <input type="text" name="tag_count" class="tag_count"
                       value="<?php if(isset($_POST['tag_count'])) { echo $_POST['tag_count']; } else { echo 0; } ?>"
                       style="display: none;">
            </li>
            <li>
                <span class="add_row">
                    <a href="" class="add_tag" value="h1"><span class="fa fa-plus-square"></span> Header-1 goş</a>
                    <a href="" class="add_tag" value="h2"><span class="fa fa-plus-square"></span> Header-2 goş</a>
                    <a href="" class="add_tag" value="h3"><span class="fa fa-plus-square"></span> Header-3 goş</a>
                    <a href="" class="add_tag" value="p"><span class="fa fa-plus-square"></span> Adaty tekst goş</a>
                    <a href="" class="add_tag" value="img"><span class="fa fa-plus-square"></span> Surat goş</a>
                </span>
                <input type="submit" name="add_book" value="Ýatda sakla" class="btn btn-danger" style="width: 15%;">
            </li>
            <li><?php if(isset($_POST['add_book']) && !empty($errors)) { output_errors($errors); } ?></li>
        </ul>
    </form>
    
    <?php
        
        } else if(isset($_GET['upd_book']))
        {
            $upd_book_info = $data_class->get_data('books', 'book_id', $_GET['upd_book'])[0];
            $xp_book_content = explode(' --- ', $upd_book_info['book_content']);
    ?>
    
    <form method="post" enctype="multipart/form-data" class="book_form" style="width: 100%;">
        <ul>
            <li>
                <input type="file" name="book_cover">
                
                <?php
                    
                    if(!empty($upd_book_info['book_cover']))
                    {
                        echo '<img src="' . $upd_book_info['book_cover'] . '" style="width: 70px;">';
                    }
                    
                ?>
                
            </li>
            <li>
                <input type="text" name="book_name" placeholder="Kitabyň ady"
                       value="<?php echo $upd_book_info['book_name']; ?>">
                <select name="writer_id">
                    <option value="">Ýazyjyny saýla</option>
                    
                    <?php
                        
                        foreach($data_class->get_data('writers') as $key => $val)
                        {
                            echo '<option value="' . $val['writer_id'] . '"';
                            
                            if($upd_book_info['writer_id'] == $val['writer_id'])
                            {
                                echo ' selected="selected"';
                            }
                            
                            echo '>' . $val['writer_name'] . '</option>';
                        }
                        
                    ?>
                    
                </select>
                <select name="genre_id">
                    <option value="">Bölüm saýla</option>
                    
                    <?php
                        
                        foreach($data_class->get_data('genres') as $key => $val)
                        {
                            echo '<option value="' . $val['genre_id'] . '"';
                            
                            if($upd_book_info['genre_id'] == $val['genre_id'])
                            {
                                echo ' selected="selected"';
                            }
                            
                            echo '>' . $val['genre_name'] . '</option>';
                        }
                        
                    ?>
                    
                </select>
            </li>
            <li class="setir"></li>
            
            <?php
                
                if(isset($_POST['tag_count']))
                {
                    $count = $_POST['tag_count'];
                } else
                {
                    $count = count($xp_book_content);
                }
                
                for($i = 1; $i <= $count; $i++)
                {
                    if(isset($_POST['tag_no-' . $i]))
                    {
                        $tag_no = $_POST['tag_no-' . $i];
                        $tag_name = $_POST['tag_name-' . $i];
                    } else if(isset($_FILES['tag_no-' . $i]['name']))
                    {
                        $tag_no = $_FILES['tag_no-' . $i];
                        $tag_name = $_POST['tag_name-' . $i];
                    } else
                    {
                        $tag_no = strip_tags($xp_book_content[$i - 1]);
                        
                        if(substr(htmlentities($xp_book_content[$i - 1]), 4, 1) == 'h')
                        {
                            $tag_name = substr(htmlentities($xp_book_content[$i - 1]), 4, 2);
                        } else if(substr(htmlentities($xp_book_content[$i - 1]), 4, 1) == 'p')
                        {
                            $tag_name = substr(htmlentities($xp_book_content[$i - 1]), 4, 1);
                        } else if(substr(htmlentities($xp_book_content[$i - 1]), 4, 3) == 'img')
                        {
                            $tag_name = substr(htmlentities($xp_book_content[$i - 1]), 4, 3);
                        }
                    }
                    
                    if($tag_name == 'h1' || $tag_name == 'h2' || $tag_name == 'h3')
                    {
                        echo '<li class="setir">';
                        echo '<input type="text" name="tag_no-' . $i . '" placeholder="' . $tag_name . ' ýaz"';
                        
                        if(isset($tag_no))
                        {
                            echo ' value="' . $tag_no . '"';
                        }
                        
                        echo '>';
                        echo '<input type="text" hidden="hidden" name="tag_name-' . $i . '" value="' . $tag_name . '">';
                        echo '</li>';
                    }
                    
                    if(!empty($tag_no) && $tag_name == 'p')
                    {
                        echo '<li class="setir">';
                        echo '<textarea name="tag_no-' . $i . '" style="width: 97%; height: 300px; margin-left: 5px;">';
                        
                        if(isset($tag_no))
                        {
                            echo $tag_no;
                        }
                        
                        echo '</textarea>';
                        echo '<input type="text" hidden="hidden" name="tag_name-' . $i . '" value="p">';
                        echo '</li>';
                    }
                    
                    if(!empty($xp_book_content[$i - 1]) && $tag_name == 'img')
                    {
                        $xp_book_img = explode('/', htmlentities($xp_book_content[$i - 1]));
                        $xp_book_img2 = explode('&', htmlentities($xp_book_img[2]));
                        
                        echo '<li class="setir">';
                        echo '<input type="file" name="tag_no-' . $i . '">';
                        echo '<input type="text" name="tag_val-' . $i . '" hidden="hidden" value="' . $xp_book_img2[0] . '">';
                        
                        if(!empty($xp_book_content[$i - 1]))
                        {
                            echo '<img src="img/book_img/' . $xp_book_img2[0] . '" style="width: 70px;">';
                        }
                        
                        echo '<input type="text" hidden="hidden" name="tag_name-' . $i . '" value="img">';
                        echo '</li>';
                    }
                }
                
            ?>
            
            <li>
                <input type="text" name="tag_count" class="tag_count"
                       value="<?php if(isset($_POST['tag_count'])) { echo $_POST['tag_count']; } else { echo count($xp_book_content) - 1; } ?>"
                       style="display: none;">
            </li>
            <li>
                <span class="add_row">
                    <a href="" class="add_tag" value="h1"><span class="fa fa-plus-square"></span> Header-1 goş</a>
                    <a href="" class="add_tag" value="h2"><span class="fa fa-plus-square"></span> Header-2 goş</a>
                    <a href="" class="add_tag" value="h3"><span class="fa fa-plus-square"></span> Header-3 goş</a>
                    <a href="" class="add_tag" value="p"><span class="fa fa-plus-square"></span> Adaty tekst goş</a>
                    <a href="" class="add_tag" value="img"><span class="fa fa-plus-square"></span> Surat goş</a>
                </span>
                <input type="submit" name="update_book" value="Ýatda sakla" class="btn btn-danger" style="width: 15%;">
            </li>
            <li><?php if(isset($_POST['update_book']) && !empty($errors)) { output_errors($errors); } ?></li>
        </ul>
    </form>
    
    <?php } ?>
    
    <?php if(!isset($_GET['add_book']) && !isset($_GET['upd_book'])) { ?>
    
    <div id="tbl_info">
        <table class="tbl_header" style="width: 100%;">
            <tr>
                <th style="width: 35%;">Kitap <input type="text" class="sbn" placeholder="" style="width: 70%;"><i class="fas fa-search"></i></th>
                <th style="width: 35%;">Ýazyjy</th>
                <th style="width: 24%;">Bölüm</th>
                <th style="width: 6%; text-align: center;"> - </th>
            </tr>
        </table>
        <table class="tbl_info" style="width: 100%;"></table>
    </div>
    
    <?php } ?>
    
    <?php require_once('includes/layout/panel_foot.php'); ?>
    
</div>

<script>
    
    $(document).ready(function(){
        
        $('.add_tag').click(function(e){
            
            e.preventDefault();
            var add_tag = $(this).attr('value');
            var tag_count = $('.tag_count').attr('value');
            
            $.post(
                'includes/jquery/get_book_form_field.php',
                {
                    add_tag: add_tag,
                    tag_count: tag_count
                },
                function(data) {
                    $('.setir:last').after(data);
                    $('.tag_count').attr('value', parseInt(tag_count) + 1);
                }
            )
            
        })
        
        $.post(
            'includes/jquery/get_book.php',
            {
                
            },
            function(data) {
                
                $('#tbl_info table.tbl_info').html(data);
                
            }
        )
        
        $('.sbn').keyup(function(){
            
            var sbn = $(this).val();
            
            if(sbn.length >= 3)
            {
                $.post(
                    'includes/jquery/get_book.php',
                    {
                        search_key: 'sbn',
                        search_val: sbn
                    },
                    function(data) {
                        
                        $('#tbl_info table.tbl_info').html(data);
                        
                    }
                )
            } else
            {
                $.post(
                    'includes/jquery/get_book.php',
                    {
                        
                    },
                    function(data) {
                        
                        $('#tbl_info table.tbl_info').html(data);
                        
                    }
                )
            }
            
        })
        
    })
    
</script>

<?php require_once('includes/layout/footer.php'); ?>