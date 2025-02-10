<?php require_once('../data_class.php'); ?>

<?php
    
    if(isset($_POST['search_key']))
    {
        if($_POST['search_key'] == 'swo')
        {
            $word_info = $data_class->search_data('words', 'word_original', $_POST['search_val']);
        } else if($_POST['search_key'] == 'swt')
        {
            $word_info = $data_class->search_data('words', 'word_translate', $_POST['search_val']);
        }
    } else
    {
        $word_info = $data_class->get_data('words');
    }
    
    if(!empty($word_info))
    {
        foreach($word_info as $key => $val)
        {
            $xp_word_original = explode(' --- ', $val['word_original']);
            $xp_word_translate = explode(' --- ', $val['word_translate']);
            $xp_word_example = explode(' --- ', $val['word_example']);
            
            echo '<tr>';
            echo '<td style="width: 27%;"><b>' . $xp_word_original[0] . '</b>';
            
            if(!empty($val['word_audio']))
            {
                echo '<span style="margin-left: 10px; color: crimson; font-size: 1.5em;"><i class="fas fa-headphones"></i></span>';
            }
            
            echo '</td>';
            echo '<td style="width: 27%;"><ul style="list-style-type: disc; margin-left: 20px;">';
            
            for($i = 0; $i < count($xp_word_translate); $i++)
            {
                echo '<li>' . $xp_word_translate[$i] . '</li>';
            }
            
            echo '</ul></td>';
            echo '<td style="width: 40%;"><ul style="list-style-type: disc; margin-left: 20px;">';
            
            for($i = 0; $i < count($xp_word_example); $i++)
            {
                $xp_we_words = explode(' ', $xp_word_example[$i]);
                
                for($j = 0; $j < count($xp_we_words); $j++)
                {
                    if(strstr($xp_we_words[$j], $val['word_original']))
                    {
                        $xp_we_words[$j] = '<b>' . $xp_we_words[$j] . '</b>';
                    }
                }
                
                $imp_word_example = implode(' ', $xp_we_words);
                
                echo '<li><i>' . $imp_word_example . '</i></li>';
            }
            
            echo '</ul></td>';
            echo '<td style="width: 6%;"><a href="words.php?upd_word=' . $val['word_id']
                    . '"><i class="fas fa-pen-square"></i></a><a href="words.php?del_word='
                    . $val['word_id'] . '"><i class="fas fa-window-close"></i></a></td>';
            echo '</tr>';
        }
    } else
    {
        echo '<tr>';
        echo '<td colspan="2" style="color: crimson; font-weight: bold;">Netije tapylmady</td>';
        echo '</tr>';
    }
    
?>