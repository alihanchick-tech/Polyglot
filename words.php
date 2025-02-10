<?php
    
    require_once('includes/init.php');
    require_once('includes/layout/aside.php');
    protect_page();
    
?>

<?php
    
    if(isset($_POST['add_word']))
    {
        $word_original = $_POST['word_original'];
        
        if(!empty($_POST['word_translate']))
        {
            $xp_word_translate = explode("\n", $_POST['word_translate']);
        }
        
        if(!empty($_POST['word_example']))
        {
            $xp_word_example = explode("\n", $_POST['word_example']);
        }
            
        for($i = 0; $i < count($xp_word_translate); $i++)
        {
            if(empty($xp_word_translate[$i]))
            {
                unset($xp_word_translate[$i]);
            }
        }
        
        for($i = 0; $i < count($xp_word_example); $i++)
        {
            if(empty($xp_word_example[$i]))
            {
                unset($xp_word_example[$i]);
            }
        }
        
        $word_translate = implode(' --- ', $xp_word_translate);
        $word_example = implode(' --- ', $xp_word_example);
        
        if(empty($word_original))
        {
            $errors[] = 'Asyl sözi ýazmaly';
        }
        
        if(empty($word_translate))
        {
            $errors[] = 'Sözüň terjimesini ýazmaly';
        }
        
        if($data_class->data_exists('words', 'word_original', $word_original))
        {
            $errors[] = 'Bu söz ulgamda bar';
        }
        
        if(!empty($_FILES['word_audio']['name']))
        {
            $allowed = array('mp3', 'wav', '3gp', 'm4a', 'MP3', 'WAV', '3GP', 'M4A');
            $file_name = basename($_FILES['word_audio']['name']);
            $file_size = $_FILES['word_audio']['size'];
            $max_file_size = "3145728"; // 3 mb
            
            $tmp = explode('.', $file_name);
            $file_extn = end($tmp);
            
            $file_temp = $_FILES['word_audio']['tmp_name'];
            
            if(!in_array($file_extn, $allowed))
            {
                $errors[] = "Bu faýl formaty rugsat berilmeýär. Rugsat berilýän faýl formatlary: mp3, wav, 3gp, m4a";
            }
            
            if($file_size > $max_file_size)
            {
                $errors[] = "Faýlyň ölçegi 3 mb-den uly bolmaly däl";
            }
        }
        
        if(empty($errors))
        {
            $word_original = $word_original . ' --- ' . strtolower($word_original) . ' --- '
                            . ucfirst($word_original) . ' --- ' . strtoupper($word_original);
            
            if(!empty($file_temp))
            {
                $file_path = 'audios/' . substr(md5($file_name), 0, 10) . '.' . $file_extn;
                move_uploaded_file($file_temp, $file_path);
            } else
            {
                $file_path = 0;
            }
            
            $add_data = array(
                'word_original' => $word_original,
                'word_translate' => $word_translate,
                'word_example' => $word_example,
                'word_audio' => $file_path
            );
            
            $data_class->add_data('words', $add_data);
            header('Location: words.php');
        }
    }
    
?>

<?php
    
    if(isset($_GET['del_word']))
    {
        $data_class->delete_data('words', 'word_id', $_GET['del_word']);
        header('Location: words.php');
    }
    
?>

<?php
    
    if(isset($_POST['update_word']))
    {
        $upd_word_info = $data_class->get_data('words', 'word_id', $_GET['upd_word'])[0];
        $word_original = $_POST['word_original'];
        
        if(!empty($_POST['word_translate']))
        {
            $xp_word_translate = explode("\n", $_POST['word_translate']);
        }
        
        if(!empty($_POST['word_example']))
        {
            $xp_word_example = explode("\n", $_POST['word_example']);
        }
            
        for($i = 0; $i < count($xp_word_translate); $i++)
        {
            if(empty($xp_word_translate[$i]))
            {
                unset($xp_word_translate[$i]);
            }
        }
        
        for($i = 0; $i < count($xp_word_example); $i++)
        {
            if(empty($xp_word_example[$i]))
            {
                unset($xp_word_example[$i]);
            }
        }
        
        $word_translate = implode(' --- ', $xp_word_translate);
        $word_example = implode(' --- ', $xp_word_example);
        
        if(empty($word_original))
        {
            $errors[] = 'Asyl sözi ýazmaly';
        }
        
        if(empty($word_translate))
        {
            $errors[] = 'Sözüň terjimesini ýazmaly';
        }
        
        if(!empty($_FILES['word_audio']['name']))
        {
            $allowed = array('mp3', 'wav', '3gp', 'm4a', 'MP3', 'WAV', '3GP', 'M4A');
            $file_name = basename($_FILES['word_audio']['name']);
            $file_size = $_FILES['word_audio']['size'];
            $max_file_size = "3145728"; // 3 mb
            
            $tmp = explode('.', $file_name);
            $file_extn = end($tmp);
            
            $file_temp = $_FILES['word_audio']['tmp_name'];
            
            if(!in_array($file_extn, $allowed))
            {
                $errors[] = "Bu faýl formaty rugsat berilmeýär. Rugsat berilýän faýl formatlary: mp3, wav, 3gp, m4a";
            }
            
            if($file_size > $max_file_size)
            {
                $errors[] = "Faýlyň ölçegi 3 mb-den uly bolmaly däl";
            }
        }
        
        if(empty($errors))
        {
            $word_original = $word_original . ' --- ' . strtolower($word_original) . ' --- '
                            . ucfirst($word_original) . ' --- ' . strtoupper($word_original);
            
            if(!empty($file_temp))
            {
                if($upd_word_info['word_audio'] != $file_path)
                {
                    $file_path = 'audios/' . substr(md5($file_name), 0, 10) . '.' . $file_extn;
                    move_uploaded_file($file_temp, $file_path);
                } else
                {
                    $file_path = $upd_word_info['word_audio'];
                }
            } else
            {
                $file_path = $upd_word_info['word_audio'];
            }
            
            $update_data = array(
                'word_original' => $word_original,
                'word_translate' => $word_translate,
                'word_example' => $word_example,
                'word_audio' => $file_path
            );
            
            $data_class->update_data('words', $update_data, 'word_id', $_GET['upd_word']);
            header('Location: words.php');
        }
    }
    
?>

<div class="content-wrapper">
    
    <?php require_once('includes/layout/panel_head.php'); ?>
    
    <?php
        
        if(isset($_GET['add_word']))
        {
            echo '<p><a href="words.php"><i class="fas fa-minus-square"></i> Goýbolsun et</a></p>';
        } else
        {
            echo '<p><a href="words.php?add_word"><i class="fas fa-plus-square"></i> Söz goş</a></p>';
        }
        
    ?>
    
    <?php if(isset($_GET['add_word'])) { ?>
    
    <form method="post" enctype="multipart/form-data" class="panel" style="width: 100%;">
        <table class="word_form" style="width: 100%;">
            <tr>
                <td colspan="2" style="color: green; font-weight: bold;">
                    *** Her söz ýa-da sözlem täze setirde (Enter bilen) ýazylmaly
                </td>
            </tr>
            <tr style="color: #fff; text-align: center;">
                <td>Asyl söz</td>
                <td>Sözüň terjimesi</td>
                <td>Sözüň sözlem içindäki ulanylyşy</td>
            </tr>
            <tr>
                <td valign="top">
                    <input type="text" name="word_original" placeholder="Asyl söz"
                           value="<?php if(isset($_POST['word_original'])) { echo $_POST['word_original']; } ?>"><br>
                    <span style="color: #fff; width: 100%; display: inline-block; text-align: center;">Ses faýly:</span>
                    <input type="file" name="word_audio">
                </td>
                <td>
                    <textarea name="word_translate"><?php if(isset($_POST['word_translate'])) { echo $_POST['word_translate']; } ?></textarea>
                </td>
                <td>
                    <textarea name="word_example"><?php if(isset($_POST['word_example'])) { echo $_POST['word_example']; } ?></textarea>
                </td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>
                    <input type="submit" name="add_word" value="Goş" class="btn btn-danger" style="width: 35%;">
                </td>
            </tr>
            <tr><td colspan="2"><?php if(isset($_POST['add_word']) && !empty($errors)) { output_errors($errors); } ?></td></tr>
        </table>
    </form>
    
    <?php
        
        } else if(isset($_GET['upd_word']))
        {
            $upd_word_info = $data_class->get_data('words', 'word_id', $_GET['upd_word'])[0];
            $xp_word_original = explode(' --- ', $upd_word_info['word_original']);
            $xp_word_translate = explode(' --- ', $upd_word_info['word_translate']);
            $xp_word_example = explode(' --- ', $upd_word_info['word_example']);
            $word_translate = implode("\n", $xp_word_translate);
            $word_example = implode("\n", $xp_word_example);
        
    ?>
    
    <form method="post" enctype="multipart/form-data" class="panel" style="width: 100%;">
        <table class="word_form" style="width: 100%;">
            <tr>
                <td colspan="2" style="color: green; font-weight: bold;">
                    *** Her söz ýa-da sözlem täze setirde (Enter bilen) ýazylmaly
                </td>
            </tr>
            <tr style="color: #fff; text-align: center;">
                <td>Asyl söz</td>
                <td>Sözüň terjimesi</td>
                <td>Sözüň sözlem içindäki ulanylyşy</td>
            </tr>
            <tr>
                <td valign="top">
                    <input type="text" name="word_original" placeholder="Asyl söz"
                           value="<?php if(isset($_POST['word_original'])) { echo $_POST['word_original']; }
                                        else { echo $xp_word_original[0]; } ?>"><br>
                    <span style="color: #fff; width: 100%; display: inline-block; text-align: center;">Ses faýly:</span>
                    <input type="file" name="word_audio">
                </td>
                <td>
                    <textarea name="word_translate"><?php if(isset($_POST['word_translate'])) { echo $_POST['word_translate']; }
                                                        else { echo $word_translate; } ?></textarea>
                </td>
                <td>
                    <textarea name="word_example"><?php if(isset($_POST['word_example'])) { echo $_POST['word_example']; }
                                                        else { echo $word_example; } ?></textarea>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <?php
                            
                        if(!empty($upd_word_info['word_audio']))
                        {
                            echo '<audio controls="">';
                            echo '<source src="' . $upd_word_info['word_audio'] . '"></source>';
                            echo '</audio>';
                        }
                        
                    ?>
                </td>
                <td>
                    <input type="submit" name="update_word" value="Üýtget" class="btn btn-danger" style="width: 35%;">
                </td>
            </tr>
            <tr><td colspan="2"><?php if(isset($_POST['add_word']) && !empty($errors)) { output_errors($errors); } ?></td></tr>
        </table>
    </form>
    
    <?php } ?>
    
    <?php if(!isset($_GET['add_word']) && !isset($_GET['upd_word'])) { ?>
    
    <div id="tbl_info">
        <table class="tbl_header" style="width: 100%;">
            <tr>
                <th style="width: 27%;">Söz <input type="text" class="swo" placeholder="" style="width: 60%;"><i class="fas fa-search"></i></th>
                <th style="width: 27%;">Terjime <input type="text" class="swt" placeholder="" style="width: 60%;"><i class="fas fa-search"></i></th>
                <th style="width: 40%;">Sözlem içinde</th>
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
        
        $.post(
            'includes/jquery/get_word.php',
            {
                
            },
            function(data) {
                
                $('#tbl_info table.tbl_info').html(data);
                
            }
        )
        
        $('.swo').keyup(function(){
            
            var swo = $(this).val();
            
            if(swo.length >= 3)
            {
                $.post(
                    'includes/jquery/get_word.php',
                    {
                        search_key: 'swo',
                        search_val: swo
                    },
                    function(data) {
                        
                        $('#tbl_info table.tbl_info').html(data);
                        
                    }
                )
            } else
            {
                $.post(
                    'includes/jquery/get_word.php',
                    {
                        
                    },
                    function(data) {
                        
                        $('#tbl_info table.tbl_info').html(data);
                        
                    }
                )
            }
            
        })
        
        $('.swt').keyup(function(){
                
            var swt = $(this).val();
            
            if(swt.length >= 3)
            {
                $.post(
                    'includes/jquery/get_word.php',
                    {
                        search_key: 'swt',
                        search_val: swt
                    },
                    function(data) {
                        
                        $('#tbl_info table.tbl_info').html(data);
                        
                    }
                )
            } else
            {
                $.post(
                    'includes/jquery/get_word.php',
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