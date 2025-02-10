<?php require_once('../data_class.php'); ?>

<div id="popup_back" style="display: none;"></div>
<div id="popup_front" style="display: none; margin-left: -300px; margin-top: -300px;">
    <div id="popup_word" style="width: 100%; margin-top: 10px; padding: 20px;"></div>
    <div id="popup_close">
        <i class="fas fa-window-close"></i>
    </div>
</div>

<?php
    
    if(isset($_POST['book_id']))
    {
        $book_id = $_POST['book_id'];
        $book_info = $data_class->get_data('books', 'book_id', $book_id)[0];
        $xp_book_content = explode(' --- ', $book_info['book_content']);
        
        for($i = 0; $i < count($xp_book_content); $i++)
        {
            $tag_no = strip_tags($xp_book_content[$i]);
                    
            if(substr(htmlentities($xp_book_content[$i]), 4, 1) == 'h')
            {
                $tag_name = substr(htmlentities($xp_book_content[$i]), 4, 2);
                $h_index[] = $i;
            }
        }
        
        if(isset($_POST['hi']))
        {
            $hi = $_POST['hi'];
            $word_info = $data_class->get_data('words');
            
            for($i = 0; $i < count($h_index); $i++)
            {
                if($h_index[$i] == $hi)
                {
                    if($i + 1 != count($h_index))
                    {
                        $next_header = $h_index[$i + 1];
                        $next_chapter = $h_index[$i + 1];
                    } else if($i + 1 == count($h_index))
                    {
                        $next_header = count($xp_book_content);
                        $next_chapter = -1;
                    }
                    
                    if($i != 0)
                    {
                        $prev_header = $h_index[$i - 1];
                        $prev_chapter = $h_index[$i - 1];
                    } else if($i == 0)
                    {
                        $prev_header = $h_index[0];
                        $prev_chapter = -1;
                    }
                    
                    for($j = $h_index[$i]; $j < $next_header; $j++)
                    {
                        $xp_word = explode(' ', $xp_book_content[$j]);
                        
                        for($m = 0; $m < count($xp_word); $m++)
                        {
                            foreach($word_info as $key => $val)
                            {
                                $xp_word_original = explode(' --- ', $val['word_original']);
                                
                                if(strstr($xp_word[$m], $xp_word_original[0]) || strstr($xp_word[$m], $xp_word_original[1])
                                   || strstr($xp_word[$m], $xp_word_original[2]) || strstr($xp_word[$m], $xp_word_original[3]))
                                {
                                    $xp_word[$m] = '<a href="" class="dict_word" value="' . $val['word_id']
                                                    . '">' . $xp_word[$m] . '</a>';
                                }
                            }
                        }
                        
                        $chapter_content = implode(' ', $xp_word);
                        echo $chapter_content;
                    }
                }
            }
            
            echo '<div style="text-align: center;">';
            
            if($prev_chapter != -1)
            {
                echo '<a href="" class="chapter" title="' . $book_id . '" value="' . $prev_header
                        . '" style="font-size: 1.1em; margin: 10px 50px;"><i class="fas fa-chevron-circle-left"></i> '
                        . strip_tags($xp_book_content[$prev_chapter]) . '</a>';
            }
            
            if($next_chapter != -1)
            {
                echo '<a href="" class="chapter" title="' . $book_id . '" value="' . $next_header
                        . '" style="font-size: 1.1em; margin: 10px 50px;">'
                        . strip_tags($xp_book_content[$next_chapter]) . ' <i class="fas fa-chevron-circle-right"></i></a>';
            }
            
            echo '</div>';
        } else
        {
            if(!empty($book_info['book_cover']))
            {
                echo '<div style="width: 70%; margin: 10px auto; text-align: center;">';
            } else
            {
                echo '<div style="width: 70%; margin: 200px auto; text-align: center;">';
            }
            
            echo '<h1>' . $book_info['book_name'] . '</h1>';
            echo '<h5>' . $data_class->get_data('writers', 'writer_id', $book_info['writer_id'])[0]['writer_name'] . '</h5>';
            echo '<h6>' . $data_class->get_data('genres', 'genre_id', $book_info['genre_id'])[0]['genre_name'] . '</h6>';
            echo '<p><i class="fas fa-hand-point-left" style="font-size: 1.5em;"></i> Bölüm saýla</p>';
            
            if(!empty($book_info['book_cover']))
            {
                echo '<img src="' . $book_info['book_cover'] . '" style="height: 380px; width: auto;">';
            }
            
            echo '</div>';
        }
    }
    
?>

<script>
    
    $('.chapters').click(function(e){
            
        e.preventDefault();
        $('.left_content').html($('.left_chapters').html());
        
    })
    
    $('.chapter').click(function(e){
            
        e.preventDefault();
        $('.chapter').removeClass('sel_chapter');
        $(this).toggleClass('sel_chapter');
        var book_id = $(this).attr('title');
        var hi = $(this).attr('value');
        $('#hi_for_jq').attr('value', hi);
        
        $.post(
            'includes/jquery/get_book_content.php',
            {
                book_id: book_id,
                hi: hi
            },
            function(data) {
                
                $('.single_right').html(data);
                
                var chapters = $('.left_chapters ul').children().children();
    
                for(var i = 0; i < chapters.length; i++)
                {
                    if(chapters[i].getAttribute('value') == hi)
                    {
                        chapters[i].setAttribute('class', 'chapter sel_chapter');
                    }
                }
                
            }
        )
    })
    
    $('.dict_word').click(function(e){
            
        e.preventDefault();
        var word_id = $(this).attr('value');
        
        $('#popup_back').css('display', 'block');
        $('#popup_front').css('height', '40px');
        $('#popup_front').css('display', 'block').animate({ 'width': '600px' }, 200).delay(200).animate({ 'height': '600px' }, 200);
        
        $.post(
            'includes/jquery/get_dict_word.php',
            {
                word_id: word_id
            },
            function(data) {
                
                setTimeout(function(){
                    
                    $('#popup_word').html(data);
                    
                }, 600);
                
            }
        )
        
    })
    
    $('#popup_close').click(function(e){
        
        $('#popup_word').html('');
        $('#popup_front').animate({ 'height': '40px' }, 200).delay(200).animate({ 'width': '40px' }, 200);
        
        setTimeout(function(){
            
            $('#popup_front').css('display', 'none');
            $('#popup_back').css('display', 'none');
            
        }, 600);
        
    })
    
    $('#popup_back').click(function(e){
        
        $('#popup_word').html('');
        $('#popup_front').animate({ 'height': '40px' }, 200).delay(200).animate({ 'width': '40px' }, 200);
        
        setTimeout(function(){
            
            $('#popup_front').css('display', 'none');
            $('#popup_back').css('display', 'none');
            
        }, 600);
        
    })
    
</script>