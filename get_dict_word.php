<?php require_once('../data_class.php'); ?>

<?php
    
    if(isset($_POST['word_id']))
    {
        $word_id = $_POST['word_id'];
        $word_info = $data_class->get_data('words', 'word_id', $word_id)[0];
        $xp_word_original = explode(' --- ', $word_info['word_original']);
        $xp_word_translate = explode(' --- ', $word_info['word_translate']);
        $xp_word_example = explode(' --- ', $word_info['word_example']);
    
?>

<div style="background: crimson; color: #fff; padding: 5px 10px; margin: 10px 0;">
    <h1>
        
        <?php
            
            echo $xp_word_original[0];
            
            if(!empty($word_info['word_audio']))
            {
                echo '<audio controls="" style="position: absolute; right: 30px;">';
                echo '<source src="' . $word_info['word_audio'] . '"></source>';
                echo '</audio>';
            }
            
        ?>
        
    </h1>
</div>
    
<?php
    
    if(!empty($xp_word_translate) && $xp_word_translate[0] != '')
    {
        echo '<div style="background: #fff; padding: 10px; margin: 10px 0; box-shadow: 3px 3px 3px lightgrey;">';
        echo '<h5>Terjimesi</h5><hr><ul style="list-style-type: disc; margin: 0 20px;">';
        
        for($i = 0; $i < count($xp_word_translate); $i++)
        {
            echo '<li style="font-size: 16px;">' . $xp_word_translate[$i] . '</li>';
        }
        
        echo '</ul>';
        echo '</div>';
    }
    
?>
    
<?php
    
    if(!empty($xp_word_example) && $xp_word_example[0] != '')
    {
        echo '<div style="background: #fff; padding: 10px; margin: 10px 0; box-shadow: 3px 3px 3px lightgrey;">';
        echo '<h5>Sözlem içinde ulanylyşy</h5><hr><ul style="list-style-type: disc; margin: 0 20px;">';
        
        for($i = 0; $i < count($xp_word_example); $i++)
        {
            // echo '<li>' . $xp_word_example[$i] . '</li>';
            $xp_we_words = explode(' ', $xp_word_example[$i]);
                
            for($j = 0; $j < count($xp_we_words); $j++)
            {
                if(strstr($xp_we_words[$j], $xp_word_original[0]) || strstr($xp_we_words[$j], $xp_word_original[1])
                    || strstr($xp_we_words[$j], $xp_word_original[2]) || strstr($xp_we_words[$j], $xp_word_original[3]))
                {
                    $xp_we_words[$j] = '<b>' . $xp_we_words[$j] . '</b>';
                }
            }
            
            $imp_word_example = implode(' ', $xp_we_words);
            
            echo '<li style="font-size: 16px;"><i>' . $imp_word_example . '</i></li>';
        }
        
        echo '</ul>';
        echo '</div>';
    }
    
?>
    
</div>

<?php } ?>